// Import the functions you need from the SDKs you need

import { initializeApp } from "firebase/app";

import { getMessaging, getToken, onMessage } from "firebase/messaging";
// import { getMessaging} from "firebase/messaging/sw";
// import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyAUdVrs_rLb2RR9LqA0uxWGQjoRyicfaBU",
  authDomain: "pallancer-ba22c.firebaseapp.com",
  projectId: "pallancer-ba22c",
  storageBucket: "pallancer-ba22c.appspot.com",
  messagingSenderId: "192685302526",
  appId: "1:192685302526:web:8c1b9ec9354058b5597baf",
  measurementId: "G-2TXEB1GH8V"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);


const messaging = getMessaging();
getToken(messaging, { vapidKey: 'BGZlABNZF_ULqHS7NtySc4als-nfIDQ1f7iEuhmRZOJybjqLyK4aXPHmYw2yx-rtAC2CaX4vaUkSREUjfZCr7Jw' }).then((currentToken) => {
  if (currentToken) {
   // console.log('yes there is token');
     console.log(currentToken);

    $.post('/api/device-tokens', {
        token: currentToken,
        device: 'chrome',
        _token: $('[name="csrf-token"]').attr('content')
    });

  } else {
    // Show permission request UI
    console.log('No registration token available. Request permission to generate one.');
    // ...
  }
}).catch((err) => {
  console.log('An error occurred while retrieving token. ', err);
  // ...
});

onMessage(messaging, (payload) => {
    console.log('Message received. ', payload);
   alert(payload.notification.body)
  });
