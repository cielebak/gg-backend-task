<table id="users" class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th class="mhidden mhidden--sm">Email</th>
            <th class="mhidden">Address</th>
            <th class="mhidden">Phone</th>
            <th class="mhidden">Company</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
        <tr>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td class="mhidden mhidden--sm"><?php echo strtolower($user['email']); ?></td>
            <td class="mhidden">
                <?php echo $user['address']['street']; ?><br>
                <?php echo $user['address']['zipcode']; ?><br>
                <?php echo $user['address']['city']; ?>
            </td>
            <td class="mhidden"><?php echo $user['phone']; ?></td>
            <td class="mhidden"><?php echo $user['company']['name']; ?></td>
            <td>
                <button class="btn btn--secondary"
                    onclick="showDeleteModal(<?php echo $user['id']; ?>)"
                >
                Delete
                </button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div id="addUserModal" class="modal">
  <div class="modal__content">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <h2 class="modal__title">Add user</h2>
    <form id="addUserForm" class="modal__form">
      <label for="name" class="visually-hidden">Name</label>
      <input type="text" id="name" name="name" data-error="nameError" class="form__control" placeholder="Name">
      <span id="nameError" class="modal__form--error-message"></span>

      <label for="username" class="visually-hidden">Username</label>
      <input type="text" id="username" data-error="usernameError" class="form__control" placeholder="Username">
      <span id="usernameError" class="modal__form--error-message"></span>

      <label for="email" class="visually-hidden">Email</label>
      <input type="email" id="email" data-error="emailError" class="form__control" placeholder="Email">
      <span id="emailError" class="modal__form--error-message"></span>

      <label for="address_street" class="visually-hidden">Street</label>
      <input type="text" id="address_street" data-error="streetError" class="form__control" placeholder="Street">
      <span id="streetError" class="modal__form--error-message"></span>

      <label for="address_suite" class="visually-hidden">Suite</label>
      <input type="text" id="address_suite" data-error="suiteError" class="form__control" placeholder="Suite">
      <span id="suiteError" class="modal__form--error-message"></span>

      <label for="address_city" class="visually-hidden">City</label>
      <input type="text" id="address_city" data-error="cityError" class="form__control" placeholder="City">
      <span id="cityError" class="modal__form--error-message"></span>

      <label for="address_zip" class="visually-hidden">Zip code</label>
      <input type="text" id="address_zip" data-error="zipError" class="form__control" placeholder="Zip code">
      <span id="zipError" class="modal__form--error-message"></span>

      <label for="phone" class="visually-hidden">Phone</label>
      <input type="text" id="phone" data-error="phoneError" class="form__control" placeholder="Phone">
      <span id="phoneError" class="modal__form--error-message"></span>

      <label for="company_name" class="visually-hidden">Company</label>
      <input type="company" id="company_name" data-error="companyError" class="form__control" placeholder="Company">
      <span id="companyError" class="modal__form--error-message"></span>

      <button class="btn" type="submit">Add user</button>
    </form>
  </div>
</div>

<div id="deleteModal" class="modal">
    <div class="modal__content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h2 class="modal__title">Delete user</h2>
        <p>Are you sure you want to delete this user?</p>
        <button id="confirmDelete" class="btn">Delete</button>
        <button id="cancelDelete" class="btn btn--secondary">Cancel</button>
    </div>
</div>
