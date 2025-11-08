-- Table for firstaid.php form data
CREATE TABLE first_aid_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_type VARCHAR(50) NOT NULL,
    pet_name VARCHAR(100),
    urgency_level VARCHAR(50) NOT NULL,
    owner_full_name VARCHAR(150) NOT NULL,
    owner_phone_number VARCHAR(20) NOT NULL,
    owner_email VARCHAR(100),
    situation_description TEXT NOT NULL,
    symptoms JSON, -- Stores checked symptoms as a JSON array
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for enjoy_service.php form data
CREATE TABLE service_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    selected_services JSON NOT NULL, -- Stores selected services (e.g., ["wellness", "grooming"])
    client_name VARCHAR(150) NOT NULL,
    pet_names VARCHAR(255) NOT NULL,
    client_email VARCHAR(100) NOT NULL,
    client_phone VARCHAR(20) NOT NULL,
    pet_type VARCHAR(50) NOT NULL,
    pet_breed VARCHAR(100),
    service_location VARCHAR(255) NOT NULL,
    help_description TEXT,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for appoinment.php form data
CREATE TABLE doctor_appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_name VARCHAR(150) NOT NULL,
    doctor_specialty VARCHAR(150),
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    patient_name VARCHAR(150) NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    owner_email VARCHAR(100),
    owner_nid VARCHAR(20),
    reason_for_visit TEXT NOT NULL,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE adoption_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    adopter_name VARCHAR(150) NOT NULL,
    adopter_email VARCHAR(100) NOT NULL,
    adopter_address TEXT NOT NULL,
    adopter_nid VARCHAR(20) NOT NULL,
    adopter_contact VARCHAR(20) NOT NULL,
    agree_care BOOLEAN NOT NULL DEFAULT 0,
    agree_visit BOOLEAN NOT NULL DEFAULT 0,
    agree_return BOOLEAN NOT NULL DEFAULT 0,
    application_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE donated_pets (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_name VARCHAR(100) NOT NULL,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(100),
    age VARCHAR(50) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    owner_name VARCHAR(150) NOT NULL,
    owner_email VARCHAR(100) NOT NULL,
    owner_phone VARCHAR(20) NOT NULL,
    rehoming_reason TEXT,
    photo_path VARCHAR(255), -- Stores the path to the uploaded image file
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(150) NOT NULL,
    customer_email VARCHAR(100),
    shipping_address TEXT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    shipping_cost DECIMAL(10, 2) NOT NULL DEFAULT 50.00,
    payment_method VARCHAR(50),
    order_status VARCHAR(50) DEFAULT 'Processing',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contact_number VARCHAR(20) UNIQUE, -- New column added here
    password VARCHAR(255) NOT NULL, 
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE donation (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10, 2) NOT NULL,
    type VARCHAR(20) NOT NULL, -- e.g., 'One Time' or 'Monthly'
    reason TEXT,
    donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);