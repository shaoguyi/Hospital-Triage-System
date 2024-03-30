CREATE TABLE doctors (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    specialty VARCHAR(255)
);

CREATE TABLE patients (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    age INT,
    gender VARCHAR(10),
    symptoms VARCHAR(255),
    severity INT,
    arrival_time INT,
    treatment_done BOOLEAN,
    doctor_id INT,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

INSERT INTO doctors (id, name, specialty) VALUES
(1, 'Dr. Smith', 'Cardiology'),
(2, 'Dr. Jones', 'Pediatrics'),
(3, 'Dr. Johnson', 'Orthopedics'),
(4, 'Dr. Lee', 'General Surgery'),
(5, 'Dr. Kim', 'Neurology'),
(6, 'Dr. Chen', 'Dermatology');

INSERT INTO patients (id, name, age, gender, symptoms, severity, arrival_time, treatment_done, doctor_id) VALUES
(1, 'John Doe', 30, 'Male', 'Cough and fever', 2, 0, false, 2),
(2, 'Jane Doe', 25, 'Female', 'Broken arm', 5, 2, false, 3),
(3, 'Mike Brown', 40, 'Male', 'Chest pain', 9, 6, false, 1),
(4, 'Anna Hill', 22, 'Female', 'Severe headache', 8, 7, false, 5),
(5, 'Tom Clark', 55, 'Male', 'Abdominal pain', 4, 15, false, 4),
(6, 'Lucy Grey', 45, 'Female', 'Skin rash', 3, 16, false, 6),
(7, 'Ethan Hunt', 35, 'Male', 'Fractured leg', 7, 20, false, 3),
(8, 'Olivia Pain', 29, 'Female', 'Burns', 6, 23, false, 4),
(9, 'Mason Ray', 50, 'Male', 'High fever', 5, 24, false, 2),
(10, 'Ava Lee', 27, 'Female', 'Dizziness', 4, 24, false, 5),
(11, 'Jacob Wells', 65, 'Male', 'Shortness of breath', 10, 27, false, 1),
(12, 'Mia Song', 38, 'Female', 'Dehydration', 3, 28, false, 2),
(13, 'Noah Flynn', 47, 'Male', 'Head injury', 6, 35, false, 3),
(14, 'Isabella Moon', 31, 'Female', 'Eye injury', 2, 37, false, 4),
(15, 'Liam Sun', 59, 'Male', 'Hypothermia', 8, 41, false, 6),
(16, 'Sophia Star', 26, 'Female', 'Electrical shock', 7, 47, false, 5),
(17, 'Elijah Storm', 44, 'Male', 'Animal bite', 5, 48, false, 3),
(18, 'Charlotte Gale', 60, 'Female', 'Heat stroke', 4, 52, false, 4),
(19, 'Logan River', 34, 'Male', 'Poisoning', 6, 59, false, 6),
(20, 'Amelia Field', 41, 'Female', 'Allergic reaction', 5, 63, false, 2);
