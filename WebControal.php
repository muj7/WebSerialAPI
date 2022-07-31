<?php
  // Filter on devices with the Arduino Vendor/Product IDs
  const filters = {
    { usbVendorId: 0x2341, usbProduxtId: 0x0043 },
    { usbVendorId: 0x2341, usbProduxtId: 0x0001 }
  };

  try {
    // Prompt user to select an Arduino Uno device
    const port = await navigator.serial.requestPort({filters});

    const { usbProduxtId, usbVendorId } = port.getInfo();
    // Continue connecting to |port|.
  } catch (e) {
    echo "Access Denied!!";
    // Permission to access a device was denied implicitly or explicitly by the user.
  }
  //Prompt user to select any serial port
  const port = await navigator.serial.requestPort();
  // witing for the serial port to open
  await port.open({ baudRate: 115200 });

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="container">
      <h2>Speech to Text</h2>
      <h6>
        <textarea
          readonly
          id="convert_text"
          placeholder="Talk to me "
          rows="5"
        ></textarea>
        <!-- make it read only to put the converted speech -->
      </h6>
      <button id="Start">Start</button>
    </div>
    <script>
      Start.addEventListener("click", function () {
        var speech = true; // should be always true
        window.SpeechRecognition = window.webkitSpeechRecognition; // request from the API to browser access to microphone

        const recognition = new SpeechRecognition();
        recognition.interimResults = true;
        recognition.lang = "ar"; // choice Arabic

        recognition.addEventListener("result", (e) => {
          const transcript = Array.from(e.results)
            .map((result) => result[0]) // take the last speech
            .map((result) => result.transcript)
            .join(""); // convert to text

          document.getElementById("convert_text").innerHTML = transcript;
          console.log(transcript);
          <?php
          // Call the write methods so, we can send data
          cost writer = port.writable.getWriter();
          //take result from the JavaScript code
          $result = $_GET['transcript'];
          await writer.write($result);
          // Allow the serial port to be closed later
          writer.releaseLock();
          // send the text to the device
          const TextEncoder = new TextEncoderStream();
          const writableStreamClosed = TextEncoder.readable.pipTo(port.writable);

          const writer.write($result);
          //closing the port
          await port.close();
           ?>
        });

        if (speech == true) {
          recognition.start();
        }
      });
    </script>
  </body>
</html>
