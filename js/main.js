$(document).ready(function() {
    // $("#submitmsg").click(function() {
    //     var usermsgs = $("$usermsg").val();

    //     $.ajax({
    //         url:"chatroom_post.php",
    //         type:"POST",
    //         async: false,
    //         data: {
    //             "done":1,
    //             "username" : name,
    //             "mess" : mess
    //         }
    //     })
 
        
    // });
    // display();
    // setInterval(function(){display().load();}, 2000)

    

    (function display(){
        $.ajax({
            url:"load.php",
            type:"POST",
            async: false,
            data: {
                "display":1 ,
            },
            success: function(data){
                $("#chattext").html(data);
            },
            complete: function(){
                setTimeout(display, 2000);
            }
        })
    })();

    // $("#submitmsg").click(function() {
    //     location.reload(true);
    // })


});