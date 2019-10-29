import {parse_json} from './parse_json';
import $ from 'jquery';
export const Game = function(sel) {
    this.sel = sel;
    var board_pieces = $(sel + " td button");
    for (var i = 0; i < board_pieces.length; ++i) {
        var board_piece = $(board_pieces.get(i));
        this.installBoardListener(board_piece);
    }

    var control = $(sel + " .controls");
    var check_button = control.find('button[name="check"]');
    this.installButtonListener(this.sel, check_button, {check: true}, "check");

    var clear_button = control.find('button[name="clear"]');
    this.installButtonListener(this.sel, clear_button, {clear: true}, "clear");

    var solve_button = control.find('button[name="solve"]');
    this.installButtonListener(this.sel, solve_button, {solve: true}, "solve");

    var no_button = control.find('button[name="no"]');
    this.installButtonListener(this.sel, no_button, {no: true}, "no");

    var yes_button = control.find('button[name="yes"]');
    this.installButtonListener(this.sel, yes_button, {yes: true}, "yes");

};

Game.prototype.installBoardListener = function(board_piece) {
    var that = this;
    board_piece.click(function (event) {

        event.preventDefault();

        var loc = this.value.split(',');
        var r = loc[0];
        var c = loc[1];
        $.ajax({
            url: "post/game-post.php",
            data: {row: r, col: c, cell: true},
            method: "POST",
            success: function(data) {
                var json = parse_json(data);
                if(json.clicked) {
                    // Successfully updated
                    that.message("<p>Successfully updated</p>");
                    var sel = that.sel;
                    var new_table = $(sel + " table");
                    new_table.html(json.view);
                    new Game(sel);
                } else {
                    // Update failed
                    that.message("<p>Update failed</p>");
                }
            },
            error: function(xhr, status, error) {
                // Error
                that.message("<p>Error: " + error + "</p>");
            }
        });
    });
};

Game.prototype.installButtonListener = function(sel, button, data, data_name) {
    var that = this;
    button.click(function (event) {
        event.preventDefault();
        $.ajax({
            url: "post/game-post.php",
            data: data,
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                if (json.hasOwnProperty(data_name)) {
                    var sel = that.sel;
                    var game = $(sel);
                    if (data_name === "check") {
                        game = $(sel + " table");
                    }
                    that.message("<p>Successfully updated</p>");
                    game.html(json.view);
                    new Game(sel);
                } else {
                    //Error
                    that.message("<p>Update failed</p>");
                }
            },
            error: function (xhr, status, error) {
                // Error
                that.message("<p>Error: " + error + "</p>");
            }
        });
    });
};

Game.prototype.message = function(message) {
    var that = this;
    $(that.sel + " .message").html(message);
    $(that.sel + " .message").html(message).hide();
};