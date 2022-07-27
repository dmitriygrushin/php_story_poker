let conn = new WebSocket('ws://localhost:8080');
const evaluateRatingForm = document.getElementById('evaluate-ratings-form');
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const room_id = urlParams.get('room_id');
const username = urlParams.get('username');
const isCreator = urlParams.get('is_creator');
const colors = ['purple', 'indianred', 'green', 'mediumpurple', 'orchid', 'lavender', 'maroon', 'indigo', 'magenta', 'olive', 'blue', 'teal', 'gray', 'purple', 'black', 'fuchsia', 'plum', 'thistle', 'violet', 'navy'];
let userListArray;
let data = [];
let HoverPie = {};

evaluateRatingForm.style.display = 'none';
if (isCreator == 'true') evaluateRatingForm.style.display = 'block';

addEventListenerToButtons();

conn.onopen = function(e) {
    console.log("Connection established!");
    conn.send(JSON.stringify({'initial_room_connection': room_id, 'username': username}));
};

conn.onmessage = function(e) {
    console.log(e.data);
    const event = JSON.parse(e.data);   
    const userListTag = document.getElementById('user-list');

    // if event contains 'user-list' then update the user list
    if (event.hasOwnProperty('user_list')) {
        // get the user list from the event
        userListArray = event['user_list'];
        // clear the user list tag
        userListTag.innerHTML = '';
        for (let [key, value] of Object.entries(userListArray)) {
            const listItem = document.createElement('li');
            listItem.style.fontSize = '1.3em';
            if (value == 0) {
              value = '✘';
            }
            listItem.innerHTML = `${key} (${value})`;
            userListTag.appendChild(listItem);
        }

        // get all values from the user list and put them in an array
        //const userListValues = Object.values(userListArray);

        // get all values from user list and put them in a hash map and count the number of times each value appears

    } else if (event.hasOwnProperty('evaluate_rating_results')) {
        if (event.evaluate_rating_results == true) {
            const userListValues = Object.values(userListArray);
            evaluateRatingResults(userListValues)
        }
    }
};

evaluateRatingForm.addEventListener('submit', (e) => {
    e.preventDefault();
    conn.send(JSON.stringify({'evaluate_rating_results': room_id}));
})

function evaluateRatingResults(userListValuesArray) {
    let userListValues = userListValuesArray.filter(function(n) { return n != 0; });
    let totalOccurrences = userListValues.length;
    let userListValuesHash = {};
    for (let i = 0; i < userListValues.length; i++) {
        if (userListValues[i] != 0) {
            if (userListValuesHash.hasOwnProperty(userListValues[i])) {
                userListValuesHash[userListValues[i]] += 1;
            } else {
                userListValuesHash[userListValues[i]] = 1;
            }
        }
    }

    let i = 0;
    // key: #, value: occurrences
    for (let [key, value] of Object.entries(userListValuesHash)) {
        data.push(createDataObject(value / totalOccurrences, colors[i++], key));
    }

    HoverPie.make($("#myCanvas"), data, {});
}

function addEventListenerToButtons() {
  for (let i = 1; i <= 10; i++) {
      const button = document.getElementById(i);
      button.addEventListener('click', function () {
          const rating = i;
          conn.send(JSON.stringify({'username': username, 'rating': rating, 'room_id': room_id}));
      });
  }

  for (let i = 15; i <= 30; i += 5) {
      const button = document.getElementById(i);
      button.addEventListener('click', function () {
          const rating = i;
          conn.send(JSON.stringify({'username': username, 'rating': rating, 'room_id': room_id}));
      });
  }

  for (let i = 40; i <= 60; i+=10) {
      const button = document.getElementById(i);
      button.addEventListener('click', function () {
          const rating = i;
          conn.send(JSON.stringify({'username': username, 'rating': rating, 'room_id': room_id}));
      });
  }

  document.getElementById(75).addEventListener('click', function () { conn.send(JSON.stringify({'username': username, 'rating': 75, 'room_id': room_id})); });
  document.getElementById(90).addEventListener('click', function () { conn.send(JSON.stringify({'username': username, 'rating': 90, 'room_id': room_id})); });
  document.getElementById(100).addEventListener('click', function () { conn.send(JSON.stringify({'username': username, 'rating': 100, 'room_id': room_id})); });
}

function createDataObject(percentage, fillColor, label) {
    return {
        percentage : percentage,
        fillColor : fillColor,
        label : label
    }
}

HoverPie.config = {
  canvasPadding : 25,
  hoverScaleX : 1.1,
  hoverScaleY : 1.1,
  labelColor : "rgba(255,255,255,1)",
  labelHoverColor : "rgba(255,255,255,1)",
  labelRadiusFactor : 0.66,
  labelFontFamily : "Arial",
  labelFontWeight : "normal",
  labelFontSize : 25,
  sectorFillColor : "#666",
  sectorStrokeColor : "#fff",
  sectorStrokeWidth : 2,
};
HoverPie.make = (function($canvas, data, config){
  config = $.extend({}, HoverPie.config, config);
  
  var percent2radians = (function(percent) { return percent*Math.PI*2; });
  
  var ctx = $canvas[0].getContext("2d");
  var oX = ctx.canvas.width/2;
  var oY = ctx.canvas.height/2;
  var r = Math.min(oX,oY) - config.canvasPadding;
  var stage = new createjs.Stage("myCanvas");
  stage.enableMouseOver(20);
  
  var cumulativeAngle = 1.5*Math.PI;
  
  for (var i=0; i<data.length; i++) {
    
    var sector = new createjs.Shape();
    var container = new createjs.Container();
    container.name = container.id;
    
    // Draw the arc
    var sectorFillColor = data[i].fillColor || config.sectorFillColor;
    var sectorStrokeColor = data[i].strokeColor || config.sectorStrokeColor;
    sector.graphics.moveTo(oX,oY).beginFill(sectorFillColor).setStrokeStyle(config.sectorStrokeWidth).beginStroke(sectorStrokeColor);
    
    var sectorAngle = percent2radians(data[i].percentage);
    sector.graphics.arc(oX,oY,r,cumulativeAngle,cumulativeAngle+sectorAngle);
    
    sector.graphics.closePath();
    
    container.addChild(sector);
    
    // Draw the label
    if (data[i].label) {
      var font = config.labelFontWeight+" "+config.labelFontSize+"px "+config.labelFontFamily;
      var unhoverLabel = new createjs.Text(data[i].label,font,config.labelColor);
      unhoverLabel.textAlign = "center";
      unhoverLabel.textBaseline = "bottom";
      
      var unhoverLabelRadius = r*config.labelRadiusFactor;
      var unhoverLabelAngle = cumulativeAngle + sectorAngle/2.0;
      unhoverLabel.x = oX + unhoverLabelRadius * Math.cos(unhoverLabelAngle);
      unhoverLabel.y = oY + unhoverLabelRadius * Math.sin(unhoverLabelAngle);
      unhoverLabel.name = "label";
      
      container.addChild(unhoverLabel);
    }
    
    container.regX = oX;
    container.regY = oY;
    container.x = oX;
    container.y = oY;
    
    cumulativeAngle+=sectorAngle;
    stage.addChild(container);
    stage.update();
  }
  
  var hovers = [];
  
  var hover = (function(ids){

    var toUnhover = [];
    for (var i=0; i<hovers.length; i++) {
      if (ids.indexOf(hovers[i]) == -1) {
        // didn't find hover[i] in ids, so add to toUnhover
        toUnhover.push(hovers[i]);
      }
    }
    for (var i=0; i<toUnhover.length; i++) {
      var child = stage.getChildByName(toUnhover[i]);
      child.scaleX = 1;
      child.scaleY = 1;
    }
    
    // and ids in ids that aren't in hovers need to be hovered
    var toHover = [];
    for (var i=0; i<ids.length; i++) {
      if (hovers.indexOf(ids[i]) == -1) {
        // didn't find ids[i] in hovers, so add to toHover
        toHover.push(ids[i]);
      }
    }
    for (var i=0; i<toHover.length; i++) {
      var child = stage.getChildByName(toHover[i]);
      child.scaleX = config.hoverScaleX;
      child.scaleY = config.hoverScaleY;
    }
    
    hovers = ids;
    stage.update();
  });
  
  $canvas.mousemove(function(e){
    var objs = stage.getObjectsUnderPoint(e.clientX,e.clientY);
    var ids = $.map(objs,function(e){ return e.parent.id; });
    
    // call hover() if ids does not match current hovers
    if (ids.length != hovers.length) {
      hover(ids);
      return;
    }
    for (var i=0; i<hovers.length; i++) {
      if (ids[i] != hovers[i]) {
        hover(ids);
        return;
      }
    }
  });
});
