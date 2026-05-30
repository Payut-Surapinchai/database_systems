-- Create a Students table that has student's id, their first name, last name, major, year level, and their gpa
CREATE TABLE Students(student_id INT PRIMARY KEY,
                                first_name VARCHAR(40),
                                last_name VARCHAR(40),
                                major VARCHAR(40),
                                year_level INT,
                                gpa DECIMAL(3,2));

-- Create an Instructors table that has instructor's id, their first name, last name, and their department
CREATE TABLE Instructors(instructor_id INT PRIMARY KEY,
                                   first_name VARCHAR(40),
                                   last_name VARCHAR(40),
                                   department VARCHAR(40));

-- Create a Courses table that has course's id, course's code, course's title, course's credits, department
-- and instructor's id
CREATE TABLE Courses(course_id INT PRIMARY KEY,
                               course_code VARCHAR(40),
                               course_title VARCHAR(40),
                               credits DECIMAL(3,1),
                               department VARCHAR(40),
                               instructor_id INT,
                               FOREIGN KEY (instructor_id) REFERENCES Instructors(instructor_id));

-- Create an Enrollments table that has enrollment id, student's id, course's id, 
-- student's semester, student's year, and student's grade
CREATE TABLE Enrollments(enrollment_id INT PRIMARY KEY,
                              student_id INT,
                              course_id INT,
                              semester VARCHAR(40),
                              year INT,
                              grade VARCHAR(2),
                              FOREIGN KEY (student_id) REFERENCES Students(student_id),
                              FOREIGN KEY (course_id) REFERENCES Courses(course_id));

-- Insert values into Students table
INSERT INTO Students(student_id, first_name, last_name, major, year_level, gpa)
                    VALUES (132, 'Kluster', 'Mukbok', 'Computer Science', 2, 3.58),
                           (158, 'Jingle', 'Plumb', 'Accounting', 1, 3.67),
                           (160, 'Nomsod', 'Grunger', 'Psychology', 3, 3.00),
                           (165, 'Elizabeth', 'Lonier', 'Zoology', 1, 3.34),
                           (167, 'Lancer', 'Knight', 'Data Science', 2, 3.90);

-- Insert values into Instructors table
INSERT INTO Instructors(instructor_id, first_name, last_name, department)
                       VALUES (10, 'Payut', 'Surapinchai', 'STEM'),
                              (11, 'Knight', 'Ropez', 'Arts & Humanities'),
                              (12, 'Russ', 'Mope', 'Social Sciences'),
                              (13, 'Lovel', 'Trainer', 'Liberal arts & Science'),
                              (14, 'Kramp', 'Schroding', 'Computer Science');

-- Insert values into Courses table
INSERT INTO Courses(course_id , course_code, course_title, credits, department, instructor_id)
                   VALUES (200, 'CSCI3412', 'Algorithms', 3.0, 'Computer Science', 14),
                          (300, 'HIST2200', 'Historical Art', 2.0, 'Arts & Humanities', 11),
                          (400, 'MATH1100', 'Calculus I', 4.0, 'STEM', 10),
                          (500, 'PHIL1700', 'Philosophy', 3.0, 'Liberal arts & Science', 13),
                          (600, 'COMM2100', 'Communications', 2.0, 'Social Sciences', 12);

-- Insert values into Enrollments table
INSERT INTO Enrollments(enrollment_id, student_id, course_id, semester, year, grade)
                  VALUES (1, 132, 200, 'Fall', 2025, 'A'),
                         (2, 132, 400, 'Fall', 2025, 'C'),
                         (3, 132, 500, 'Fall', 2025, 'B'),
                         (4, 132, 600, 'Fall', 2025, 'B'),
                         (5, 158, 400, 'Fall', 2025, 'A-'),
                         (6, 158, 500, 'Fall', 2025, 'A'),
                         (7, 160, 500, 'Spring', 2025, 'B-'),
                         (8, 165, 400, 'Fall', 2025, 'C'),
                         (9, 165, 600, 'Fall', 2025, 'A-'),
                         (10, 167, 200, 'Spring', 2025, 'A'),
                         (11, 167, 400, 'Spring', 2025, 'A'),
                         (12, 167, 300, 'Spring', 2025, 'A');

-- Query 1 
SELECT first_name, last_name, major FROM Students;

-- Query 2
SELECT * FROM Students WHERE gpa > 3.50;

-- Query 3
SELECT * FROM Students WHERE major = 'Computer Science' AND gpa >= 3.00;

-- Query 4
SELECT * FROM Students ORDER BY gpa DESC;

-- Query 5
SELECT * FROM Courses, Instructors 
WHERE Courses.instructor_id = Instructors.instructor_id AND Instructors.department = 'Computer Science';

-- Query 6
SELECT course_code, course_title, first_name, last_name FROM Courses, Instructors 
WHERE Courses.instructor_id = Instructors.instructor_id;

-- Query 7
SELECT department, COUNT(*) AS number_courses FROM Courses GROUP BY department;

-- Query 8
SELECT course_code, course_title FROM Courses, Enrollments 
WHERE Enrollments.course_id = Courses.course_id 
GROUP BY Courses.course_code, Courses.course_title, Courses.course_id HAVING Count(*) > 10;

-- Query 9
SELECT first_name, last_name FROM Enrollments, Students 
WHERE Enrollments.student_id = Students.student_id
GROUP BY Students.first_name, Students.last_name, Students.student_id HAVING COUNT(*) > 3;

-- Query 10
SELECT first_name, last_name FROM Students WHERE gpa = (SELECT MAX(gpa) FROM Students);