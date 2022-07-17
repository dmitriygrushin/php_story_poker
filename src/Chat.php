<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

include_once '../src/User.php';

class Chat implements MessageComponentInterface {
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

    // Adds user to room. If room doesn't exist, create it.
    private function addUserToRoom($conn, $room_id, $username) {
        if (!isset($this->rooms[$room_id])) $this->rooms[$room_id] = array();
        $this->rooms[$room_id][] = new \User($username, $room_id, $conn);
        echo "Added user to room! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $new_msg = json_decode($msg, true);

        if (isset($new_msg['initial_room_connection'])) {
            $this->addUserToRoom($from, $new_msg['initial_room_connection'], $new_msg['username']);
        } else {
            // Send message to all users in the same room
            foreach ($this->rooms[$new_msg['room_id']] as $user) {
                // Broadcast message
                if ($user->getConn() != $from) $user->getConn()->send($new_msg['message']);
                //$user->getConn()->send($new_msg['message']);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        // Remove user from room
        foreach ($this->rooms as $room_id => $room) {
            foreach ($room as $user) {
                if ($user->getConn() === $conn) {
                    unset($this->rooms[$room_id][$user->getUsername()]);
                    echo "Removed user from room! ({$conn->resourceId})\n";
                }
            }
        }

        // if no more users in room, remove room
        foreach ($this->rooms as $room_id => $room) {
            if (count($room) === 0) {
                unset($this->rooms[$room_id]);
                echo "Removed room! ({$room_id})\n";
            }
        }

        echo "Connection {$conn->resourceId} has disconnected\n";
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
