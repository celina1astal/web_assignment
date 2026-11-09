
<?php
$submitted = false;
$errors = [];

$data = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'dob' => '',
    'gender' => '',
    'course' => '',
    'address' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($data as $key => $value) {
        $data[$key] = trim($_POST[$key] ?? '');
    }

    if ($data['name'] === '') {
        $errors['name'] = 'Name is required.';
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if (!preg_match('/^[0-9+\-\s()]{7,20}$/', $data['phone'])) {
        $errors['phone'] = 'Enter a valid phone number.';
    }

    if ($data['dob'] === '') {
        $errors['dob'] = 'Date of birth is required.';
    }

    if (!in_array($data['gender'], ['Female', 'Male', 'Other'], true)) {
        $errors['gender'] = 'Select a valid gender.';
    }

    if (!in_array($data['course'], [
        'Computer Science',
        'Information Science',
        'Electronics',
        'Mechanical',
        'Business Administration'
    ], true)) {
        $errors['course'] = 'Select a valid course.';
    }

    if ($data['address'] === '') {
        $errors['address'] = 'Address is required.';
    }

    if (($_POST['declaration'] ?? '') !== 'yes') {
        $errors['declaration'] = 'Please accept the declaration.';
    }

    if (empty($errors)) {
        $submitted = true;
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>1RF24CS045-Online Registration Form</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background: #e6daf2;
    color: #26382d;
    padding: 30px 15px;
}

.container {
    max-width: 800px;
    margin: auto;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.header {
    background: #802ae8;
    color: white;
    text-align: center;
    padding: 28px 20px;
}

.header h1 {
    margin-bottom: 10px;
    font-size: 28px;
}

.header p {
    color: #e3f3e8;
    font-size: 14px;
}

.content {
    padding: 30px;
}

h2 {
    font-size: 19px;
    color: #802ae8;
    margin: 5px 0 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e0ebe3;
}

.form-row {
    display: flex;
    gap: 18px;
}

.form-group {
    flex: 1;
    margin-bottom: 20px;
    min-width: 0;
}

label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 8px;
}

.required {
    color: #d74747;
}

input, select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccd9cf;
    border-radius: 6px;
    font-family: inherit;
    font-size: 14px;
    outline: none;
}

input:focus, select:focus, textarea:focus {
    border-color: #802ae8;
    box-shadow: 0 0 0 3px #e5f3e9;
}

textarea {
    resize: vertical;
}

.invalid {
    border-color: #d74747;
}

.error {
    display: block;
    color: #c0392b;
    font-size: 12px;
    margin-top: 5px;
}

.declaration {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 20px;
    font-size: 13px;
    line-height: 1.5;
}

.declaration input {
    width: auto;
    margin-top: 3px;
}

.declaration label {
    font-weight: normal;
    margin: 0;
}

button {
    background: #802ae8;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 14px 18px;
    width: 100%;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #802ae8;
}

.notice {
    background: #fff0ed;
    border: 1px solid #f0c9c2;
    color: #a33164;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 20px;
    font-size: 13px;
}

.success {
    text-align: center;
    color: #802ae8;
    margin-bottom: 15px;
}

.success p {
    color: #66756b;
    margin-top: 10px;
    line-height: 1.6;
}

.result-table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
    table-layout: fixed;
}

.result-table th,
.result-table td {
    border: 1px solid #dce6de;
    padding: 13px;
    text-align: left;
    overflow-wrap: anywhere;
    line-height: 1.5;
}

.result-table th {
    background: #eaf4ed;
    color: #7326d0;
    width: 35%;
}

.result-table td {
    color: #34443a;
}

.footer {
    text-align: center;
    background: #f8faf8;
    padding: 18px;
    color: #78877c;
    font-size: 12px;
    border-top: 1px solid #e3eae4;
}

.actions {
    display: flex;
    gap: 12px;
}

.actions button,
.actions a {
    flex: 1;
    text-align: center;
    text-decoration: none;
    border-radius: 6px;
    padding: 13px;
    font-size: 14px;
}

.actions a {
    background: #e6f1e9;
    color: #802ae8;
    font-weight: bold;
}

@media (max-width: 600px) {
    .form-row {
        flex-direction: column;
        gap: 0;
    }

    .content {
        padding: 22px 18px;
    }

    .header h1 {
        font-size: 23px;
    }

    .result-table th,
    .result-table td {
        padding: 9px;
        font-size: 13px;
    }
}

@media print {
    body {
        background: white;
        padding: 0;
    }

    .container {
        box-shadow: none;
        max-width: 100%;
    }

    .header {
        background: white;
        color: #6b1acd;
        border-bottom: 2px solid #802ae8;
    }

    .header p,
    .actions,
    .footer {
        display: none;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Online Registration Form</h1>
        <p>Complete the form to submit your application</p>
    </div>

    <div class="content">

    <?php if ($submitted): ?>

        <div class="success">
            <h2>✓ Registration Successful!</h2>
            <p>
                Thank you, <strong><?= e($data['name']) ?></strong>.
                Your application details are shown below.
            </p>
        </div>

        <h2>Application Details</h2>

        <table class="result-table">
            <tr>
                <th>Full Name</th>
                <td><?= e($data['name']) ?></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><?= e($data['email']) ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?= e($data['phone']) ?></td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td><?= e($data['dob']) ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= e($data['gender']) ?></td>
            </tr>
            <tr>
                <th>Selected Course</th>
                <td><?= e($data['course']) ?></td>
            </tr>
            <tr>
                <th>Residential Address</th>
                <td><?= nl2br(e($data['address'])) ?></td>
            </tr>
        </table>

        <div class="actions">
            <button type="button" onclick="window.print()">
                Print Application
            </button>

            <a href="<?= e($_SERVER['PHP_SELF']) ?>">
                New Registration
            </a>
        </div>

    <?php else: ?>

        <h2>Personal Information</h2>

        <?php if (!empty($errors)): ?>
            <div class="notice">
                Please correct the errors highlighted below.
            </div>
        <?php endif; ?>

        <form method="POST" id="registrationForm"
              action="<?= e($_SERVER['PHP_SELF']) ?>" novalidate>

            <div class="form-group">
                <label for="name">Full Name <span class="required">*</span></label>
                <input type="text" id="name" name="name"
                       placeholder="Enter your full name"
                       value="<?= e($data['name']) ?>" required>
                <small class="error"><?= e($errors['name'] ?? '') ?></small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email"
                           placeholder="example@email.com"
                           value="<?= e($data['email']) ?>" required>
                    <small class="error"><?= e($errors['email'] ?? '') ?></small>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone"
                           placeholder="+91 98765 43210"
                           value="<?= e($data['phone']) ?>" required>
                    <small class="error"><?= e($errors['phone'] ?? '') ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="dob">Date of Birth <span class="required">*</span></label>
                    <input type="date" id="dob" name="dob"
                           value="<?= e($data['dob']) ?>" required>
                    <small class="error"><?= e($errors['dob'] ?? '') ?></small>
                </div>

                <div class="form-group">
                    <label for="gender">Gender <span class="required">*</span></label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <?php foreach (['Female', 'Male', 'Other'] as $option): ?>
                            <option value="<?= e($option) ?>"
                                <?= $data['gender'] === $option ? 'selected' : '' ?>>
                                <?= e($option) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="error"><?= e($errors['gender'] ?? '') ?></small>
                </div>
            </div>

            <h2>Application Details</h2>

            <div class="form-group">
                <label for="course">Program Applying For <span class="required">*</span></label>
                <select id="course" name="course" required>
                    <option value="">Select a Course</option>
                    <?php
                    $courses = [
                        'Computer Science',
                        'Information Science',
                        'Electronics',
                        'Mechanical',
                        'Business Administration'
                    ];
                    foreach ($courses as $course):
                    ?>
                        <option value="<?= e($course) ?>"
                            <?= $data['course'] === $course ? 'selected' : '' ?>>
                            <?= e($course) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="error"><?= e($errors['course'] ?? '') ?></small>
            </div>

            <div class="form-group">
                <label for="address">Residential Address <span class="required">*</span></label>
                <textarea id="address" name="address" rows="4"
                          placeholder="Enter your complete address"
                          required><?= e($data['address']) ?></textarea>
                <small class="error"><?= e($errors['address'] ?? '') ?></small>
            </div>

            <div class="declaration">
                <input type="checkbox" id="declaration"
                       name="declaration" value="yes"
                       <?= ($_POST['declaration'] ?? '') === 'yes' ? 'checked' : '' ?>
                       required>
                <label for="declaration">
                    I confirm that the information provided is accurate
                    to the best of my knowledge.
                </label>
            </div>

            <small class="error" style="margin-top:-14px;margin-bottom:16px">
                <?= e($errors['declaration'] ?? '') ?>
            </small>

            <button type="submit">Submit Application</button>

        </form>

    <?php endif; ?>

    </div>

    <div class="footer">
        Online Registration Portal | All Rights Reserved
    </div>

</div>

<script>
$(document).ready(function () {

    $('#registrationForm').on('submit', function (event) {
        let valid = true;
        let firstInvalid = null;

        $(this).find('input[required], select[required], textarea[required]')
            .each(function () {
                const field = $(this);
                const value = $.trim(field.val() || '');
                let fieldValid = true;

                if (field.attr('type') === 'checkbox') {
                    fieldValid = field.is(':checked');
                } else if (value === '') {
                    fieldValid = false;
                } else if (field.attr('type') === 'email') {
                    fieldValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                } else if (field.attr('name') === 'phone') {
                    fieldValid = /^[0-9+\-\s()]{7,20}$/.test(value);
                }

                field.toggleClass('invalid', !fieldValid);

                if (!fieldValid) {
                    valid = false;
                    if (!firstInvalid) {
                        firstInvalid = field;
                    }
                }
            });

        if (!valid) {
            event.preventDefault();
            firstInvalid.trigger('focus');
        }
    });

    $('#registrationForm').on('input change', 'input, select, textarea', function () {
        $(this).removeClass('invalid');
    });

});
</script>

</body>
</html>
