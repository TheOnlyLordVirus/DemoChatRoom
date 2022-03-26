$('#postMessage').on('click', function (event)
{
  event.preventDefault();

  $.post("../php/sendChat.php", { message: $("#message").val() })
  .done(function(result) 
  {
    console.info("Message sent:");
    console.log($("#message").val());
  })
  .fail(function(error) 
  {
    console.info("Message failed to send:");
    console.error(error);
  });
});

function updateLoop()
{
  // Jquery Ajax shortcut.
  $.post("../php/getChat.php",
    function (data)
    {
        $("#chatTable").html(data);
    }
  );

  setTimeout(updateLoop, 50/*Milliseconds*/);
}

updateLoop();