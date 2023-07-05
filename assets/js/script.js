class UserManagement {
  async deleteUser(id) {
    try {
      const response = await fetch('actions/deleteUser.php', {
        method: 'POST',
        body: new URLSearchParams({
          id: id
        })
      });
      const data = await response.text();

      // Display the response message
      // alert(data);

      // Reload the page
      location.reload();
    } catch (error) {
      // Handle any errors
      console.error('Error:', error);
    }
  }

  async addUser(user) {
    try {
      const response = await fetch('actions/addUser.php', {
        method: 'POST',
        body: JSON.stringify(user),
        headers: {
          'Content-Type': 'application/json'
        }
      });

      const data = await response.text();

      // Display the response message
      // alert(data);

      // Reload the page
      location.reload();
    } catch (error) {
      // Handle any errors
      console.error('Error:', error);
    }
  }
}

// Retrieves geolocation coordinates for a given address
async function getGeolocation(address) {
  const url = 'https://geocode.maps.co/search?q=' + encodeURIComponent(address);

  try {
    const response = await fetch(url);
    const data = await response.json();

    if (data && data.length > 0) {
      // Extract the latitude and longitude from the response
      const latitude = data[0].lat || 0; // Set default value to 0 if lat is not available
      const longitude = data[0].lon || 0; // Set default value to 0 if lon is not available

      return {
        lat: latitude,
        lng: longitude
      };
    } else {
      // Geolocation data not found, provide default values
      return {
        lat: 0,
        lng: 0
      };
    }
  } catch (error) {
    console.error('Error:', error);
    throw new Error('Failed to retrieve geolocation');
  }
}

const userManagement = new UserManagement();

// Handle user delete
function showDeleteModal(id) {
  const modal = document.getElementById('deleteModal');
  const confirmButton = document.getElementById('confirmDelete');
  const cancelButton = document.getElementById('cancelDelete');

  modal.style.display = 'flex';

  // Add click event listener to the confirm button
  confirmButton.onclick = function () {
    userManagement.deleteUser(id);
    modal.style.display = 'none';
  };

  // Add click event listener to the cancel button
  cancelButton.onclick = function () {
    modal.style.display = 'none';
  };
}

// Handle add user form
function showAddUserModal() {
  const addUserModal = document.getElementById('addUserModal');
  addUserModal.style.display = 'flex';

  const addUserForm = document.getElementById('addUserForm');
  addUserForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    // Input refs
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const addressStreetInput = document.getElementById('address_street');
    const addressSuiteInput = document.getElementById('address_suite');
    const addressCityInput = document.getElementById('address_city');
    const addressZipInput = document.getElementById('address_zip');
    const phoneInput = document.getElementById('phone');
    const companyNameInput = document.getElementById('company_name');

    // Input values
    const name = nameInput.value;
    const username = usernameInput.value;
    const email = emailInput.value;
    const addressStreet = addressStreetInput.value;
    const addressSuite = addressSuiteInput.value;
    const addressCity = addressCityInput.value;
    const addressZip = addressZipInput.value;
    const address = addressStreet + ' ' + addressSuite + ', ' + addressCity + ', ' + addressZip;
    let addressLat = 0;
    let addressLong = 0;
    const phone = phoneInput.value;
    const companyName = companyNameInput.value;

    // Input validation
    const validationRules = [
      { input: nameInput, errorId: 'nameError', message: 'Name is required.' },
      { input: usernameInput, errorId: 'usernameError', message: 'Username is required.' },
      { input: emailInput, errorId: 'emailError', message: 'Email is required.' },
      { input: emailInput, errorId: 'emailError', message: 'Invalid email format.', validator: validateEmail },
      { input: addressStreetInput, errorId: 'streetError', message: 'Street is required.' },
      { input: addressSuiteInput, errorId: 'suiteError', message: 'Suite is required.' },
      { input: addressCityInput, errorId: 'cityError', message: 'City is required.' },
      { input: addressZipInput, errorId: 'zipError', message: 'Zip code is required.' },
      { input: phoneInput, errorId: 'phoneError', message: 'Phone is required.' },
      { input: companyNameInput, errorId: 'companyError', message: 'Company is required.' }
    ];

    let isValid = true;

    validationRules.forEach(({ input, errorId, message, validator }) => {
      const value = input.value.trim();
      const errorElement = document.getElementById(errorId);

      if (value === '' || (validator && !validator(value))) {
        errorElement.textContent = message;
        input.classList.add('form__control--error');
        isValid = false;
      } else {
        errorElement.textContent = '';
        input.classList.remove('form__control--error');
      }
    });

    if (!isValid) {
      return;
    }

    try {
      const geolocation = await getGeolocation(address);

      addressLat = geolocation.lat;
      addressLong = geolocation.lng;

      const user = {
        name,
        username,
        email,
        addressStreet,
        addressSuite,
        addressCity,
        addressZip,
        addressLat,
        addressLong,
        phone,
        companyName
      };

      // Call the addUser
      await userManagement.addUser(user);

      addUserModal.style.display = 'none';
    } catch (error) {
      console.error('Error:', error);
    }
  });

  // Add input event listeners to remove error class and clear error message on typing
  const formInputs = addUserForm.querySelectorAll('input');
  formInputs.forEach((input) => {
    input.addEventListener('input', () => {
      input.classList.remove('form__control--error');
      const errorElementId = input.getAttribute('data-error');
      const errorElement = document.getElementById(errorElementId);
      if (errorElement) {
        errorElement.textContent = '';
      }
    });
  });
}

// Close modal
function closeModal() {
  const modals = document.getElementsByClassName('modal');
  Array.from(modals).forEach(function (modal) {
    modal.style.display = 'none';
  });
}

// Close the modals when the user clicks outside of them
window.addEventListener('click', function (event) {
  const modals = document.getElementsByClassName('modal');
  Array.from(modals).forEach(function (modal) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
});

// Email validation using regex
function validateEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}
