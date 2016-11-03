<!doctype html>
<!-- author: Kyle Burton -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Debug - WPBTS</title>
</head>
<body>
    <button id="btn-events">Get Events</button>
    <p id="p-events"></p>
    <button id="btn-clinics">Get Clinics</button>
    <p id="p-clinics"></p>
    <button id="btn-token">Update device token</button>
    <p id="p-devicetokens"></p>
    <button id="btn-rsvp">RSVP</button>
    <p id="p-rsvp"></p>
    <footer>
        
    </footer>

</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<!--<script src="js/bootstrap.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
        
      //ajax
      
      $(function () {

        $('#btn-events').on('click', function ()
        {
                //e.preventDefault();
                $('#p-events').empty();
                
                $.ajax({
                        url: 'api/events/view_events.php',
                        type: 'post',
                        data: {'eventid': 1},
                        cache: false,
                        success: function (json)
                        {
                                $('#p-events').empty();
                                $('#p-events').append("JSON: " + JSON.stringify(json));
                        },
                        error: function (xhr, desc, err)
                        {
                                console.log(xhr + "\n" + err);
                                $('#p-events').append("failed, :" + xhr + "\n" + err);
                        }
                }); // end ajax call
        });
        $('#btn-clinics').on('click', function ()
        {
                //e.preventDefault();
                $('#p-clinics').empty();
                
                $.ajax({
                        url: 'api/clinics/view_Clinics.php',
                        type: 'post',
                        data: {'eventid': 1},
                        cache: false,
                        success: function (json)
                        {
                                $('#p-clinics').empty();
                                $('#p-clinics').append("JSON: " + JSON.stringify(json));
                        },
                        error: function (xhr, desc, err)
                        {
                                console.log(xhr + "\n" + err);
                                $('#p-clinics').append("failed, :" + xhr + "\n" + err);
                        }
                }); // end ajax call
        });
        $('#btn-token').on('click', function ()
        {
                //e.preventDefault();
                $('#p-devicetokens').empty();
                
                $.ajax({
                        url: 'api/firebase/device_token_registration.php',
                        type: 'post',
                        data: {'userid': 1, 'devicetoken': 'testtoken'},
                        cache: false,
                        success: function (json)
                        {
                                $('#p-devicetokens').empty();
                                $('#p-devicetokens').append("JSON: " + JSON.stringify(json));
                        },
                        error: function (xhr, desc, err)
                        {
                                console.log(xhr + "\n" + err);
                                $('#p-devicetokens').append("failed, :" + xhr + "\n" + err);
                        }
                }); // end ajax call
        });
        $('#btn-rsvp').on('click', function ()
        {
                //e.preventDefault();
                $('#p-rsvo').empty();
                
                $.ajax({
                        url: 'api/events/rsvp.php',
                        type: 'post',
                        data: {'userid': 5, 'eventid': 3, 'attending': 1},
                        cache: false,
                        success: function (json)
                        {
                                $('#p-rsvp').empty();
                                $('#p-rsvp').append("JSON: " + JSON.stringify(json));
                        },
                        error: function (xhr, desc, err)
                        {
                                console.log(xhr + "\n" + err);
                                $('#p-rsvp').append("failed, :" + xhr + "\n" + err);
                        }
                }); // end ajax call
        });
    });
    
</script>
</html>