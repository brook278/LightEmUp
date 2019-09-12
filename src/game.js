import {parse_json} from './parse_json';
import $ from 'jquery';
export const Game = function(sel) {
    this.sel = sel;
    var that = this;
    var board_pieces = $(sel + " td button");
    for (var i = 0; i < board_pieces.length; ++i) {
        var board_piece = $(board_pieces.get(i));
        this.installButtonListener(board_piece);
    }
    var control = $(sel + " .controls");
    var check_button = control.find('button[name="check"]');
    check_button.click(function (event) {
        event.preventDefault();
        $.ajax({
            url: "post/game-post.php",
            data: {check: true},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                if (json.check) {
                    var sel = that.sel;
                    var new_table = $(sel + " table");
                    that.message("<p>Successfully updated</p>");
                    new_table.html(json.view);
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
    var clear_button = control.find('button[name="clear"]');
    clear_button.click(function (event) {
        event.preventDefault();
        $.ajax({
            url: "post/game-post.php",
            data: {clear: true},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                if (json.clear) {
                    var sel = that.sel;
                    var game = $(sel + ".game");
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
    var solve_button = control.find('button[name="solve"]');
    solve_button.click(function (event) {
        event.preventDefault();
        $.ajax({
            url: "post/game-post.php",
            data: {solve: true},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                if (json.solve) {
                    var sel = that.sel;
                    var game = $(sel + ".game");
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
    var yes_button = control.find('button[name="yes"]');
    yes_button.click(function (event) {
        event.preventDefault();
        $.ajax({
            url: "post/game-post.php",
            data: {yes: true},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                if (json.yes) {
                    var sel = that.sel;
                    var game = $(sel + ".game");
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
    var no_button = control.find('button[name="no"]');
    no_button.click(function (event) {
        event.preventDefault();
        $.ajax({
            url: "post/game-post.php",
            data: {no: true},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                if (json.no) {
                    var sel = that.sel;
                    var game = $(sel + ".game");
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
}

Game.prototype.installButtonListener = function(board_piece) {
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
}

Game.prototype.message = function(message) {
    var that = this;
    $(that.sel + " .message").html(message);
    $(that.sel + " .message").fadeIn(1000);
    $(that.sel + " .message").show().delay(2000).fadeOut(1000);
}