<!DOCTYPE HTML>
<html>
    <head>
        <title>Resident Registration | Binswiper</title>
        <link type="text/css" rel="stylesheet" href="../../css_files/style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
        integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
        crossorigin=""></script>
        <script>
            var mymap = L.map('mapid').setView([51.505, -0.09], 13);
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox.streets',
                accessToken: 'your.mapbox.access.token'
            }).addTo(mymap);
        </script>
        <style>
            *{
                color:#002246;
            }

            .reg-form-box{
                display:grid;
                grid-template-columns: auto auto;
                grid-column-gap:1px;
                box-shadow:0 0 8px #002246;
                border-radius:3px;
                padding:20px;
                width:75%;
            }

            .submit_button{
                background-color:transparent;
                border:1px solid transparent;
                box-shadow:0 0 4px #002246;
                border-radius:4px;
                padding:10px 20px;
                cursor:pointer;
                color:#002246;
            }

            .submit_button:hover{
                box-shadow:0 0 10px #002246;
            }

            #mapid{
                height:180px;
            }
            
        </style>
    </head>
    <body style="margin:0;padding:0;">
        <h1 style="text-align:center"><i class="fa fa-trash-o"></i> Binswiper</h1>
        <div align="center">
            <div class="reg-form-box">
                <div>
                    <h3>Sign Up!</h3>
                    <form method="POST" action="registration_complete.php">
                        <input type="text" name="nic" placeholder="NIC" style="text-transform:uppercase" class="input-box" required /><br/>
                        <input type="text" name="fullname" placeholder="Full Name" style="text-transform:capitalize" class="input-box" required /><br/>
                        <input type="text" name="tan" placeholder="Tax Account Number" class="input-box" /><br/>
                        <input type="number" name="phone" placeholder="Phone" class="input-box" required /><br/>
                        <input type="text" name="email" placeholder="Email" class="input-box" /><br/>
                        <input type="text" name="address" placeholder="Address" style="text-transform:capitalize" class="input-box" required /><br/><br/>
                        <input type="hidden" name="locationCoordinate" value="" />
                        <input type="submit" class="submit_button" value="Sign Up" />
                    </form>
                </div>
                <div>
                    <div id="mapid"></div>
                </div>
            </div>
        </div>
        <h5 style="text-align:center">Already a member? <a href="../../../index.php" style="color:#002246">Click here to log in</a></h5>
    </body>
</html>