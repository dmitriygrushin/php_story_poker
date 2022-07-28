<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

include_once '../src/User.php';

class Chat implements MessageComponentInterface {
    /* TODO: Change clients to an array of User objects 
     * The time complexity of finding the user to remove them from the room is O(n^2)
     * which can be reduced among other tasks.
     */ 
    
    protected $clients; // array of connections
    protected $rooms; // array of room names => array of User objects

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->rooms = array();
        echo "Server started\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $event_type = json_decode($msg, true);

        // event type handler
        if (isset($event_type['initial_room_connection'])) {
            $this->addUserToRoom($from, $event_type['initial_room_connection'], $event_type['username']);
            $this->updateUserList($event_type['initial_room_connection']);
        } else if (isset($event_type['rating'])) {
            $this->updateUserPoints($event_type['username'], $event_type['rating'], $event_type['room_id']);
            $this->updateUserList($event_type['room_id']);
        } else if (isset($event_type['evaluate_rating_results'])) {
            $this->evaluateRatingResults($event_type['evaluate_rating_results']);
        } else if (isset($event_type['refresh_room_id'])) {
            $this->sendRefresh($event_type['refresh_room_id']);
        } else {
            echo "Unknown event type\n";
            /*
            // Send message to all users in the same room
            foreach ($this->rooms[$event_type['room_id']] as $user) {
                // Broadcast message
                if ($user->getConn() != $from) $user->getConn()->send($event_type['rating']);
                //$user->getConn()->send($event_type['message']);
            }
            */
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $connsRoomId = $this->getRoomId($conn);
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        $this->removeUserFromRoom($conn);
        $this->updateUserList($connsRoomId);
        $this->removeRoomIfEmpty($connsRoomId);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    // send refresh to room_id
    private function sendRefresh($room_id) {
        foreach ($this->rooms[$room_id] as $user) {
            $user->getConn()->send(json_encode(array('refresh' => true)));
        }
    } 

    // sends signal to all clients in the room to evaluate the ratings
    private function evaluateRatingResults($roomId) {
        foreach ($this->rooms[$roomId] as $user) {
            $json_data = json_encode(array('evaluate_rating_results' => true));
            $user->getConn()->send($json_data);
        }
    }

    // if no more users in room, remove room
    private function removeRoomIfEmpty($room_id) {
        if (count($this->rooms[$room_id]) === 0) {
            unset($this->rooms[$room_id]);
            echo "Removed room! ({$room_id})\n";
        }
    }

    // update user points from room_id
    private function updateUserPoints($username, $rating, $room_id) {
        $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (is_numeric($rating)) {
            foreach ($this->rooms[$room_id] as $user) {
                if ($user->getUsername() === $username) {
                    $user->setPoints($rating);
                }
            }
        }
    }

    // get $conn's room_id
    private function getRoomId($conn) {
        foreach ($this->rooms as $room_id => $room) {
            foreach ($room as $user) {
                if ($user->getConn() == $conn) return $room_id;
            }
        }
        return null;
    }

    private function removeUserFromRoom($conn) {
        foreach ($this->rooms as $room_id => $users) {
            foreach ($users as $key => $user) {
                if ($user->getConn() == $conn) {
                    unset($this->rooms[$room_id][$key]);
                    echo "Removed user from room! ({$conn->resourceId})\n";
                }
            }
        }
    }

    // Adds user to room. If room doesn't exist, create it.
    private function addUserToRoom($conn, $room_id, $username) {
        $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!isset($this->rooms[$room_id])) $this->rooms[$room_id] = array();
        $this->rooms[$room_id][] = new \User($username, $room_id, $conn);
        echo "Added user to room! ({$conn->resourceId})\n";
    }

    // Get user list from room as an array users => array of User objects
    private function getUserList($room_id) {
        // new array of users => array of User objects from room
        $users = array();
        if (!isset($this->rooms[$room_id])) return $users;
        foreach ($this->rooms[$room_id] as $user) {
            $users[$user->getUsername()] = $user->getPoints();
        }
        return $users;
    }
    
    // send user list to all clients in the room as JSON
    private function updateUserList($room_id) {
        $user_list = $this->getUserList($room_id);
        $user_list_json = json_encode($user_list);
        $user_list_json = '{"user_list":' . $user_list_json . '}';
        foreach ($this->rooms[$room_id] as $user) {
            $user->getConn()->send($user_list_json);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
/*
 * Steps: (NON-TECHNICAL)
 * 0. Client Creates Room (Master Client)
 * 1. Clients Join Room
 * 2. Clients vote
 * 3. Room displays who voted
 * 4. Master Client clicks complete
 * 5. Room displays votes
 *
 * Steps: (TECHNICAL)
 * 1.0. Client Creates Room (Master Client)
 * 	1.1. (Master Client) POST parameters will have: [username, room_id, is_master = true]
 * 	1.2. (Master Client) will send JSON message of 'initial_room_connection' - (Server) add room to hashmap and add Master Client to array of users connected to that room
 * 	1.3. (Master Client) Votes - Master Client sends vote to (Server) - adds vote and notifies Clients that this user voted
 *
 * 2.0. Client Joins Room
 * 	2.1. Same as 1.2 & 1.3
 *
 * 3.0. (Master Client) - Clicks submit: (Server) - Calculates result and sends it to call the clients as a JSON message of {complete = true} so all clients will display the complete vote ratio
 *
 */
