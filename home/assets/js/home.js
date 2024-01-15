document.getElementById('bookNowButton').addEventListener('click', function() {
    var confirmation = confirm('Are you sure you want to initiate a phone call?');
    if (confirmation) {
      window.location.href = 'tel:+1234567890'; // Replace with your phone number
    }
  });