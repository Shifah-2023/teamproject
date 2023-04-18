<?php

class Operations
{
    private $con;
    private $db;
    public $tbStud = 'students',
        $tbSchools = 'school',
        $tbAdmins = 'admins',
        $tbclasses = 'classes',
        $tbusers = 'users',
        $tbsubjects = 'subjects',
        $tbprojectdetails = 'projectdetails',
        $tbprojecttypes = 'project_type',
        $tbprojectmarks = 'projec_tmarks',
        $tbResults = 'results',
        $tbStuclassHist = 'studclasshistory',
        $tbstudschoolHist = 'studentschoolhistory',
        $tbTest = 'tests',
        $tbStaff = 'staff',
        $tbContact = 'contactinfo',
        $tbPro = 'projects',
        $id,
        $sch_id,
        $project_name,
        $stud_name,
        $email,
        $LIN,
        // $contact,	
        // $image,	
        $class_id,
        // $password,	
        $created,
        $createdby,
        $modified,
        $modifiedby,
        // sch
        $regNo,
        $school_name,
        $address,
        // users
        $fname,
        $lname,
        $contact,
        $user_type,
        $password,
        $sub_name,
        $subj_id,
        $stud_id,
        $mark,
        $pro_details_id,
        $marks,
        $pid,
        $result_id,
        $image,
        $ID,
        $description,
        $project_types,
        $groups,
        $individual,
        $project_type_id,
        $user_id,
        $project_type,
        $subject_id,
        $username,
        $name;
    function __construct()
    {
        require_once dirname(__FILE__) . './Connect.php';

        $this->db = new Connect();

        $this->con = $this->db->connect();
    }

    // function to login using ADMIN table
    public function slogin()
    {
        $stmt = $this->con->prepare(
            'SELECT * FROM  ' .
                $this->tbAdmins .
                ' WHERE email = ? AND password = ?'
        );
        //sanitize incoming data
        $this->email = $this->sanitizeInput(
            'Username',
            $this->email,
            STRING
        );
        $this->password = $this->sanitizeInput(
            'Password',
            $this->password,
            STRING
        );
        $stmt->bind_param('ss', $this->email, $this->password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return SCHOOL_ADMIN_AUTHENTICATED;
        } else {
            return SCHOOL_ADMIN_AUTHENTICATION_FAILED;
        }
    }

    // gt projecttypebyid

    public function getProjectTypeWithId()
    {
        $stmt = $this->con->prepare(
            'SELECT ID,project_types,groups,individual, createdby, created, modifiedby, modified FROM ' .
                $this->tbprojecttypes .
                ' WHERE ID = ?'
        );

        $this->ID = $this->sanitizeInput(
            'Project Type Id',
            $this->ID,
            INTEGER
        );
        $stmt->bind_param('i', $this->ID);
        $stmt->execute();
        $stmt->bind_result(
            $ID,
            $project_types,
            $groups,
            $individual,
            $createdby,
            $created,
            $modifiedby,
            $modified
        );
        $stmt->store_result();
        $stmt->fetch();

        $level = [];
        $level['ID'] = $ID;
        $level['project_types'] = $project_types;
        $level['groups'] = $groups;
        $level['individual'] = $individual;

        return $level;
    }
    // / get admin id using an email
    function getAdminidByEmail()
    {
        $stmt = $this->con->prepare('SELECT ID FROM admins WHERE email = ? ');
        $this->email = $this->sanitizeInput(
            'Username.',
            $this->email,
            STRING
        );
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();

        return $id;
    }

    // get admin id using an email
    function getProjectidByname()
    {
        $stmt = $this->con->prepare('SELECT id FROM projects WHERE email = ? ');
        $username = $this->sanitizeInput(
            'Usernamegetst.',
            $this->username,
            STRING
        );
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();

        return $id;
    }

    // get students id using an id
    public function getStudentsidByEmail($username)
    {
        $stmt = $this->con->prepare('SELECT id FROM students WHERE email = ? ');
        $username = $this->sanitizeInput(
            'Username.',
            $username,
            STRING
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();

        return $id;
    }

    public function getSchoolidByEmail($username)
    {
        $stmt = $this->con->prepare('SELECT id FROM schools WHERE email = ? ');
        $username = $this->sanitizeInput(
            'Username.',
            $username,
            STRING
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();

        return $id;
    }
    // FUNCTION TO GET AN ADMIN id
    public function getAdminNameByEmail($username)
    {
        $stmt = $this->con->prepare('SELECT name FROM staff WHERE email = ? ');
        $username = $this->sanitizeInput(
            'Username.',
            $username,
            STRING
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($name);
        $stmt->fetch();

        return $name;
    }
    // login. this was using admin table
    public function AdminLogsin()
    {
        $stmt = $this->con->prepare(
            'SELECT * FROM  ' .
                $this->tbAdmins .
                ' WHERE email = ? AND password = ?'
        );
        //sanitize incoming data
        $this->email = $this->sanitizeInput('Username', $this->email, STRING);
        $this->password = $this->sanitizeInput(
            'Password',
            $this->password,
            STRING
        );
        $stmt->bind_param('ss', $this->email, $this->password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return SCHOOL_ADMIN_AUTHENTICATED;
        } else {
            return SCHOOL_ADMIN_AUTHENTICATION_FAILED;
        }
    }

    // get timeandDate
    public function getDateandTime()
    {
        return date('y/m/d h:i:sa');
    }

    // function to create schools
    public function createSchools()
    {
        if (!$this->isSchoolExisting()) {
            $query = $this->con->prepare(
                'INSERT INTO ' .
                    $this->tbSchools .
                    '($regNo,$school_name,$address,created,createdby) VALUES (?,?,?,?,?)'
            );
            // sanitize incoming input
            $this->regNo = $this->sanitizeInput(
                'regNo ',
                $this->regNo,
                INTEGER
            );
            $this->address = $this->sanitizeInput(
                'School Address',
                $this->address,
                STRING
            );
            $this->school_name = $this->sanitizeInput(
                'school_name ',
                $this->school_name,
                STRING
            );

            $this->createdby = $this->sanitizeInput(
                'Created By',
                $this->createdby,
                INTEGER
            );
            $this->created = $this->sanitizeInput(
                'Created On',
                $this->created,
                STRING
            );

            $query->bind_param(
                'issis',
                $this->school_name,
                $this->address,
                $this->school_name,
                $this->createdby,
                $this->created
            );
            if ($query->execute()) {
                return SCHOOL_CREATED;
            } else {
                return SCHOOL_CREATION_FAILED;
            }
        } else {
            return SCHOOL_EXISTS;
        }
    }
    // create subjects

    public function createSc()
    {
        if (!$this->isSchoolExisting()) {
            $query = $this->con->prepare(
                'INSERT INTO ' .
                    $this->tbSchools .
                    '($regNo,$school_name,$address,created,createdby) VALUES (?,?,?,?,?)'
            );
            // sanitize incoming input
            $this->regNo = $this->sanitizeInput(
                'regNo ',
                $this->regNo,
                INTEGER
            );
            $this->address = $this->sanitizeInput(
                'School Address',
                $this->address,
                STRING
            );
            $this->school_name = $this->sanitizeInput(
                'school_name ',
                $this->school_name,
                STRING
            );

            $this->createdby = $this->sanitizeInput(
                'Created By',
                $this->createdby,
                INTEGER
            );
            $this->created = $this->sanitizeInput(
                'Created On',
                $this->created,
                STRING
            );

            $query->bind_param(
                'issis',
                $this->school_name,
                $this->address,
                $this->school_name,
                $this->createdby,
                $this->created
            );
            if ($query->execute()) {
                return SCHOOL_CREATED;
            } else {
                return SCHOOL_CREATION_FAILED;
            }
        } else {
            return SCHOOL_EXISTS;
        }
    }
    // function to get all schools
    public function retrieveAllSchools()
    {
        $query = $this->con->prepare(
            'SELECT ID,	school_name,address,regNo,created,createdby,modifiedby,modified FROM ' .
                $this->tbSchools
        );
        $query->execute();
        $query->bind_result(
            $ID,
            $school_name,
            $address,
            $regNo,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $schools = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $school = [];
                $school['sn'] = $sn;
                $school['ID'] = $ID;
                $school['school_name'] = $school_name;
                $school['address'] = $address;
                $school['regNo'] = $regNo;
                $school['created'] = $created;
                $school['createdby'] = $createdby;
                $school['modifiedby'] = $modifiedby;
                $school['modified'] = $modified;

                array_push($schools, $school);
            }
            return $schools;
        } else {
            return 'No Schools found';
        }
    }

    // function to delete school
    public function deleteSchool()
    {
        $query = $this->con->prepare('DELETE FROM schools WHERE id = ?');
        //sanitize id coming
        $this->id = $this->sanitizeInput(
            'School Id',
            $this->id,
            INTEGER
        );
        $query->bind_param('i', $this->id);
        if ($query->execute()) {
            return SCHOOL_DELETED;
        } else {
            return SCHOOL_DELETION_FAILED;
        }
    }

    // function to update school school
    public function updateSchool()
    {
        $query = $this->con->prepare(
            'UPDATE schools SET school_name = ?, address = ?,phone = ?,regNo = ?,modifiedby = ?,modified = ? WHERE id = ? '
        );
        //sanitize incoming data
        $this->school_name = $this->sanitizeInput(
            'School Name',
            $this->school_name,
            STRING
        );
        $this->address = $this->sanitizeInput(
            'School Address',
            $this->address,
            STRING
        );
        $this->regNo = $this->sanitizeInput(
            'regNo',
            $this->regNo,
            INTEGER
        );

        $this->modifiedby = $this->sanitizeInput(
            'Modified By',
            $this->modifiedby,
            INTEGER
        );
        $this->modified = $this->sanitizeInput(
            'Modified On',
            $this->modified,
            STRING
        );
        $this->id = $this->sanitizeInput(
            'School Id',
            $this->id,
            INTEGER
        );

        $query->bind_param(
            'ssiisi',
            $this->school_name,
            $this->address,
            $this->regNo,
            $this->modifiedby,
            $this->modified,
            $this->id
        );

        if ($query->execute()) {
            return SCHOOL_UPDATED;
        } else {
            return SCHOOL_UPDATE_FAILED;
        }
    }

    // UPDATE SUBJECTS
    public function updateSubject()
    {
        $query = $this->con->prepare(
            'UPDATE subjects SET sub_name = ?,modifiedby = ?,modified = ? . WHERE ID = ? '
        );
        //sanitize incoming data
        $this->sub_name = $this->sanitizeInput(
            'Subject',
            $this->sub_name,
            STRING
        );
        $this->modifiedby = $this->sanitizeInput(
            'Modified By',
            $this->modifiedby,
            INTEGER
        );
        $this->modified = $this->sanitizeInput(
            'Modified On',
            $this->modified,
            STRING
        );
        $this->ID = $this->sanitizeInput(
            'Subject Id',
            $this->ID,
            INTEGER
        );

        $query->bind_param(
            'sisi',
            $this->sub_name,
            $this->modifiedby,
            $this->modified,
            $this->ID
        );

        if ($query->execute()) {
            return SUBJECT_UPDATED;
        } else {
            return SUBJECT_UPDATE_FAILED;
        }
    }


    // function to check if school exists in the database
    public function isSchoolExisting()
    {
        $query = $this->con->prepare(
            'SELECT name FROM ' .
                $this->tbSchools .
                ' WHERE email = ? OR phone = ?'
        );
        // sanitize input
        $this->regNo = $this->sanitizeInput(
            'School Email',
            $this->regNo,
            INTEGER
        );
        $this->address = $this->sanitizeInput(
            'Mobile Phone',
            $this->address,
            STRING
        );
        $query->bind_param('ss', $this->regNo, $this->address);
        $query->execute();
        $query->store_result();
        return $query->num_rows > 0;
    }

    // function to check if the student exists
    public function isStudentExisting()
    {
        $query = $this->con->prepare(
            'SELECT name FROM ' .
                $this->tbStud .
                ' WHERE regno = ? OR email = ?'
        );
        // sanitize input
        $this->LIN = $this->sanitizeInput(
            'Registration No',
            $this->LIN,
            STRING
        );
        $this->email = $this->sanitizeInput(
            'Student Email',
            $this->email,
            STRING
        );

        $query->bind_param('ss', $this->LIN, $this->email);
        $query->execute();
        $query->store_result();
        return $query->num_rows > 0;
    }


    public function isSubjectExisting()
    {
        $query = $this->con->prepare(
            'SELECT sub_name FROM ' .
                $this->tbSchools .
                ' WHERE sub_name '
        );
        // sanitize input
        $this->sub_name = $this->sanitizeInput(
            'Subject Name',
            $this->sub_name,
            STRING
        );

        $query->bind_param('s', $this->sub_name);
        $query->execute();
        $query->store_result();
        return $query->num_rows > 0;
    }

    // ceate subjects
    public function createSubjects()
    {
        if (!$this->isSubjectExisting()) {
            $query = $this->con->prepare(
                'INSERT INTO subjects(sub_name, created, createdby) VALUES (?,?,?)'
            );

            // sanitize incoming input
            $this->sub_name = $this->sanitizeInput(
                'student name',
                $this->sub_name,
                STRING
            );
            $this->createdby = $this->sanitizeInput(
                'Created By',
                $this->createdby,
                INTEGER
            );
            $this->created = $this->sanitizeInput(
                'Created On',
                $this->created,
                STRING
            );
            $query->bind_param(
                'sis',
                $this->sub_name,
                $this->createdby,
                $this->created
            );
            if ($query->execute()) {
                return SUBJECT_CREATED;
            } else {
                return SUBJECT_CREATION_FAILED;
            }
        } else {
            return SUBJECT_EXITS;
        }
    }

    // function to create student
    public function createStudent()
    {
        if (!$this->isStudentExisting()) {
            $query = $this->con->prepare(
                'INSERT INTO ' .
                    $this->tbStud .
                    '( $id,	
                    $sch_id,	
                    $stud_name,	
                    $email,	
                    $LIN,	
                    $contact,	
                    $image,	
                    $class_id,	
                    $password,	,createdby,created) VALUES (?,?,?,?,?,?,?,?,?,?,?,)'
            );

            // sanitize incoming input
            $this->sch_id = $this->sanitizeInput(
                'school id',
                $this->sch_id,
                INTEGER
            );
            $this->stud_name = $this->sanitizeInput(
                'student name',
                $this->stud_name,
                STRING
            );
            $this->email = $this->sanitizeInput(
                'Email Address',
                $this->email,
                STRING
            );
            $this->LIN = $this->sanitizeInput(
                'LIN',
                $this->LIN,
                STRING
            );
            $this->contact = $this->sanitizeInput(
                'contact No',
                $this->contact,
                STRING
            );
            $this->image = $this->sanitizeInput(
                'District id',
                $this->image,
                STRING
            );
            $this->class_id = $this->sanitizeInput(
                'class id',
                $this->class_id,
                INTEGER
            );
            $this->password = $this->sanitizeInput(
                'class id',
                $this->password,
                STRING
            );
            $this->createdby = $this->sanitizeInput(
                'Created By',
                $this->createdby,
                INTEGER
            );
            $this->created = $this->sanitizeInput(
                'Created On',
                $this->created,
                STRING
            );
            $this->username = $this->sanitizeInput(
                'Created On',
                $this->username,
                STRING
            );
            $query->bind_param(
                'isssssisis',
                $this->sch_id,
                $this->stud_name,
                $this->email,
                $this->LIN,
                $this->contact,
                $this->image,
                $this->username,
                $this->class_id,
                $this->password,
                $this->createdby,
                $this->created
            );
            if ($query->execute()) {
                return STUDENT_CREATED;
            } else {
                return STUDENT_CREATE_FAILED;
            }
        } else {
            return STUDENT_EXISTS;
        }
    }

    public function retrieveAllResults()
    {
        $query = $this->con->prepare(
            'SELECT r.ID, st.stud_name,su.sub_name, r.mark,r.created,r.createdby,r.modifiedby,r.modified FROM results as r,subjects as su, students as st WHERE subj_id = su.ID AND stud_id = st.ID '
        );
        $query->execute();
        $query->bind_result(
            $ID,
            $stud_name,
            $sub_name,
            $mark,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $students = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $student = [];
                $student['sn'] = $sn;
                $student['ID'] = $ID;
                $student['stud_name'] = $stud_name;
                $student['sub_name'] = $sub_name;
                $student['mark'] = $mark;
                $student['created'] = $created;
                $student['createdby'] = $createdby;
                $student['modifiedby'] = $modifiedby;
                $student['modified'] = $modified;

                array_push($students, $student);
            }
            return $students;
        } else {
            return 'No Results found';
        }
    }

    //function to get all students
    public function retrieveAllStudents()
    {
        $query = $this->con->prepare(
            'SELECT st.ID,st.stud_name,st.email,st.LIN,st.contact, s.school_name, c.name,st.image,st.created,st.createdby,st.modifiedby,st.modified FROM students as st,
                classes as c, school as s WHERE sch_id = st.sch_id AND class_id = st.class_id ORDER BY st.ID ASC '

        );
        $query->execute();
        $query->bind_result(
            $ID,
            $stud_name,
            $email,
            $LIN,
            $contact,
            $school_name,
            $class_name,
            $image,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $students = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $student = [];
                $student['sn'] = $sn;
                $student['ID'] = $ID;
                $student['stud_name'] = $stud_name;
                $student['email'] = $email;
                $student['school_name'] = $school_name;
                $student['LIN'] = $LIN;
                $student['contact'] = $contact;
                $student['class_name'] = $class_name;
                $student['image'] = $image;
                $student['created'] = $created;
                $student['createdby'] = $createdby;
                $student['modifiedby'] = $modifiedby;
                $student['modified'] = $modified;

                array_push($students, $student);
            }
            return $students;
        } else {
            return 'No Students found';
        }
    }

    public function retrieveAllSubjects()
    {
        $query = $this->con->prepare(
            'SELECT ID, sub_name, created, createdby, modified, modifiedby FROM subjects '

        );
        $query->execute();
        $query->bind_result(
            $ID,
            $sub_name,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $students = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $student = [];
                $student['sn'] = $sn;
                $student['ID'] = $ID;
                $student['sub_name'] = $sub_name;
                $student['created'] = $created;
                $student['createdby'] = $createdby;
                $student['modifiedby'] = $modifiedby;
                $student['modified'] = $modified;

                array_push($students, $student);
            }
            return $students;
        } else {
            return 'No Subjects found';
        }
    }

    public function deleteSubjects()
    {
        $query = $this->con->prepare('DELETE FROM `subjects` WHERE ID = ?');
        //sanitize id coming
        $this->ID = $this->sanitizeInput(
            'Student Id',
            $this->ID,
            INTEGER
        );
        $query->bind_param('i', $this->ID);
        if ($query->execute()) {
            return SUBJECT_DELETED;
        } else {
            return SUBJECT_DELETION_FAILED;
        }
    }

    public function getSubjectById()
    {
        $query = $this->con->prepare(
            'SELECT ID, sub_name, created, createdby, modified, modifiedby FROM subjects WHERE ID = ? '
        );
        $this->ID = $this->sanitizeInput(
            'Student id',
            $this->ID,
            INTEGER
        );
        $query->bind_param('i', $this->ID);
        $query->execute();
        $query->bind_result(
            $ID,
            $sub_name,
            $createdby,
            $created,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $query->fetch();

        $student = [];
        $student['ID'] = $ID;
        $student['sch_id'] = $sub_name;
        return $student;
    }

    // function to delete students
    // public function deleteStudent()
    // {
    //     $query = $this->con->prepare('DELETE FROM students WHERE id = ?');
    //     //sanitize id coming
    //     $this->id = $this->sanitizeInput(
    //         'Student Id',
    //         $this->id,
    //         INTEGER
    //     );
    //     $query->bind_param('i', $this->id);
    //     if ($query->execute()) {
    //         return STUDENT_DELETED;
    //     } else {
    //         return STUDENT_DELETION_FAILED;
    //     }
    // }

    // Functio to update student
    // public function updateStudent()
    // {
    //     $query = $this->con->prepare(

    //         'UPDATE students SET sch_id = ?, stud_name = ?,email = ?,password = ?,username = ?,contact = ?,image  = ?,class_id = ?,password = ?,modifiedby = ?,modified = ? WHERE id = ? '
    //     );
    //     //sanitize incoming data
    //     $this->stud_name = $this->sanitizeInput(
    //         'Student Name',
    //         $this->stud_name,
    //         STRING
    //     );
    //     $this->sch_id = $this->sanitizeInput(
    //         'school id',
    //         $this->sch_id,
    //         INTEGER
    //     );
    //     $this->email = $this->sanitizeInput(
    //         'Email Address',
    //         $this->email,
    //         STRING
    //     );
    //     $this->password = $this->sanitizeInput(
    //         'Password',
    //         $this->password,
    //         STRING
    //     );
    //     $this->username = $this->sanitizeInput(
    //         'username ',
    //         $this->username,
    //         STRING

    //     );
    //     $this->LIN = $this->sanitizeInput(
    //         'regno id',
    //         $this->LIN,
    //         INTEGER
    //     );
    //     $this->password = $this->sanitizeInput(
    //         'password ',
    //         $this->password,
    //         STRING
    //     );
    //     $this->contact = $this->sanitizeInput(
    //         'contact ',
    //         $this->contact,
    //         INTEGER
    //     );
    //     $this->image = $this->sanitizeInput(
    //         'images ',
    //         $this->image,
    //         INTEGER
    //     );
    //     $this->class_id = $this->sanitizeInput(
    //         'class_id ',
    //         $this->class_id,
    //         INTEGER
    //     );
    //     $this->modifiedby = $this->sanitizeInput(
    //         'Modified By',
    //         $this->modifiedby,
    //         INTEGER
    //     );
    //     $this->modified = $this->sanitizeInput(
    //         'Modified On',
    //         $this->modified,
    //         STRING
    //     );
    //     $this->id = $this->sanitizeInput(
    //         'Student Id',
    //         $this->id,
    //         INTEGER
    //     );

    //     $query->bind_param(
    //         'sisssisiiiisi',

    //         $this->sch_id,
    //         $this->stud_name,
    //         $this->email,
    //         $this->password,
    //         $this->username,
    //         $this->LIN,
    //         $this->contact,
    //         $this->image,
    //         $this->class_id,
    //         $this->modifiedby,
    //         $this->modified,
    //         $this->id
    //     );

    //     if ($query->execute()) {
    //         return STUDENT_UPDATED;
    //     } else {
    //         return STUDENT_UPDATE_FAILED;
    //     }
    // }

    // function to get student using id '
    // public function getStudentWithId()
    // {
    //     $query = $this->con->prepare(
    //         'SELECT st.ID,s.school_name, st.stud_name,st.email,st.LIN,st.contact,st.image, c.name,st.created,st.createdby,st.modifiedby,st.modified FROM students as st,
    //             classes as c, school as s WHERE sch_id = st.sch_id AND class_id = st.class_id ORDER BY st.ID AND st.ID = ? '
    //     );
    //     $this->id = $this->sanitizeInput(
    //         'Student id',
    //         $this->ID,
    //         INTEGER
    //     );
    //     $query->bind_param('i', $this->ID);
    //     $query->execute();
    //     $query->bind_result(
    //         $ID,
    //         $sch_id,
    //         // $school_name,
    //         // $class_name,
    //         $stud_name,
    //         $email,
    //         $LIN,
    //         $contact,
    //         $image,
    //         $class_id,
    //         $createdby,
    //         $created,
    //         $modifiedby,
    //         $modified
    //     );
    //     $query->store_result();
    //     $query->fetch();

    //     $student = [];
    //     $student['ID'] = $ID;
    //     $student['sch_id'] = $sch_id;
    //     $student['stud_name'] = $stud_name;
    //     $student['email'] = $email;
    //     $student['contact'] = $contact;
    //     $student['LIN'] = $LIN;
    //     $student['image'] = $image;
    //     $student['class_id'] = $class_id;

    //     return $student;
    // }

    // public function getResultsWithId()
    // {

    //     $query = $this->con->prepare(
    //         'SELECT r.ID,su.sub_name, st.stud_name,r.mark,r.created,r.createdby,r.modifiedby,r.modified FROM results as r,subjects as su, students as st WHERE subj_id = su.ID AND stud_id = st.ID AND r.ID = ? '
    //     );
    //     $this->ID = $this->sanitizeInput(
    //         'Results id',
    //         $this->ID,
    //         INTEGER
    //     );
    //     $query->bind_param('i', $this->ID);
    //     $query->execute();
    //     $query->bind_result(
    //         $ID,
    //         $sub_name,
    //         $stud_name,
    // $marks,
    //         $createdby,
    //         $created,
    //         $modifiedby,
    //         $modified
    //     );
    //     $query->store_result();
    //     $query->fetch();

    //     $student = [];
    //     $student['ID'] = $ID;
    //     $student['sub_name'] = $sub_name;
    //     $student['stud_name'] = $stud_name;
    // $student['marks'] = $marks;
    //     return $student;
    // }

    // function for school by id
    // public function getSchoolWithId()
    // {
    //     $query = $this->con->prepare(
    //         'SELECT ID, regNo, school_name, address, created, createdby, modified, modifiedby FROM school WHERE ID = ? '
    //     );
    //     $this->ID = $this->sanitizeInput(
    //         'Student id',
    //         $this->ID,
    //         INTEGER
    //     );
    //     $query->bind_param('i', $this->ID);
    //     $query->execute();
    //     $query->bind_result(
    //         $ID,
    //         $school_name,
    //         $address,
    //         $regNo,
    //         $createdby,
    //         $created,
    //         $modifiedby,
    //         $modified
    //     );
    //     $query->store_result();
    //     $query->fetch();

    //     $student = [];
    //     $student['ID'] = $ID;
    //     $student['school_name'] = $school_name;
    //     $student['address'] = $address;
    //     $student['regNo'] = $regNo;

    //     return $student;
    // }

    // fucntion to create users
    // function createUsers()
    // {
    //     if (!$this->isUserExisting()) {
    //         $query = $this->con->prepare(
    //             'INSERT INTO ' .
    //                 $this->tbusers .
    //                 '(id,fname,lname,email,contact,user_type,password,createdby,created) VALUES (?,?,?,?)'
    //         );

    //         // sanitize incoming input
    //         $this->fname = $this->sanitizeInput(
    //             'fname ',
    //             $this->fname,
    //             STRING
    //         );
    //         $this->lname = $this->sanitizeInput(
    //             'lname ',
    //             $this->lname,
    //             STRING
    //         );
    //         $this->email = $this->sanitizeInput(
    //             'email ',
    //             $this->email,
    //             STRING
    //         );
    //         $this->contact = $this->sanitizeInput(
    //             'contact ',
    //             $this->contact,
    //             INTEGER
    //         );
    //         $this->password = $this->sanitizeInput(
    //             'password ',
    //             $this->password,
    //             STRING
    //         );
    //         $this->user_type = $this->sanitizeInput(
    //             'user_type ',
    //             $this->user_type,
    //             STRING
    //         );
    //         $this->createdby = $this->sanitizeInput(
    //             'Created By',
    //             $this->createdby,
    //             INTEGER
    //         );
    //         $this->created = $this->sanitizeInput(
    //             'Created On',
    //             $this->created,
    //             STRING
    //         );

    //         $query->bind_param(
    //             'sssissis',
    //             $this->fname,
    //             $this->lname,
    //             $this->email,
    //             $this->contact,
    //             $this->user_type,
    //             $this->password,
    //             $this->createdby,
    //             $this->created
    //         );
    //         if ($query->execute()) {
    //             return USERS_CREATED;
    //         } else {
    //             return USERS_CREATE_FAILED;
    //         }
    //     } else {
    //         return USERS_EXISTS;
    //     }
    // }

    // check if the user exists
    // public function isUserExisting()
    // {
    //     $query = $this->con->prepare(
    //         ' SELECT email FROM ' .
    //             $this->tbusers .
    //             ' WHERE email = ? OR contact = ?'
    //     );
    //     // sanitize input
    //     $this->email = $this->sanitizeInput(
    //         'email ',
    //         $this->email,
    //         STRING
    //     );
    //     // $this->classid = $this->sanitizeInput(
    //     //     'Class Id',
    //     //     $this->classid,
    //     //     INTEGER
    //     // );
    //     $query->bind_param('si', $this->email);
    //     $query->execute();
    //     $query->store_result();
    //     return $query->num_rows > 0;
    // }

    public function retrieveAllUser()
    {
        $query = $this->con->prepare(
            'SELECT id,	fname,lname,email,created,contact,user_type,password,createdby,modifiedby,modified FROM ' .
                $this->tbStuclassHist
        );
        $query->execute();
        $query->bind_result(
            $id,
            $fname,
            $lname,
            $email,
            $contact,
            $user_type,
            $password,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $students = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $user = [];
                $user['sn'] = $sn;
                $user['id'] = $id;
                $user['studid'] = $fname;
                $user['classid'] = $lname;
                $user['classid'] = $email;
                $user['classid'] = $contact;
                $user['classid'] = $user_type;
                $user['classid'] = $password;
                $user['created'] = $created;
                $user['createdby'] = $createdby;
                $user['modifiedby'] = $modifiedby;
                $user['modified'] = $modified;

                array_push($users, $user);
            }
            return $users;
        } else {
            return 'No data found';
        }
    }
    // function to delete users
    public function deleteUsers()
    {
        $query = $this->con->prepare(
            'DELETE FROM users WHERE id = ?'
        );
        $this->id = $this->sanitizeInput(
            'user id',
            $this->id,
            INTEGER
        );
        $query->bind_param('i', $this->id);
        if ($query->execute()) {
            return USERS_DELETED;
        } else {
            return USERS_DELETION_FAILED;
        }
    }

    // function to update student class history
    public function updateUser()
    {
        $query = $this->con->prepare(
            'UPDATE users SET fname	= ?, lname  = ?,email = ?,contact = ?,user_type = ?,password = ?, modifiedby = ?,modified = ? WHERE id = ? '
        );
        //sanitize incoming data
        $this->fname = $this->sanitizeInput(
            'first name',
            $this->fname,
            STRING
        );
        $this->lname = $this->sanitizeInput(
            'last name',
            $this->lname,
            STRING
        );
        $this->email = $this->sanitizeInput(
            'email ',
            $this->email,
            STRING
        );
        $this->contact = $this->sanitizeInput(
            'contact ',
            $this->contact,
            INTEGER
        );
        $this->user_type = $this->sanitizeInput(
            'user_type',
            $this->user_type,
            STRING
        );
        $this->password = $this->sanitizeInput(
            'password ',
            $this->password,
            STRING
        );
        $this->modifiedby = $this->sanitizeInput(
            'Modified By',
            $this->modifiedby,
            INTEGER
        );
        $this->modified = $this->sanitizeInput(
            'Modified On',
            $this->modified,
            STRING
        );
        $this->id = $this->sanitizeInput(
            'History Id',
            $this->id,
            INTEGER
        );
        $query->bind_param(
            'SSSISSISI',
            $this->fname,
            $this->lname,
            $this->email,
            $this->contact,
            $this->user_type,
            $this->password,
            $this->modifiedby,
            $this->modified,
            $this->id
        );
        if ($query->execute()) {
            return USERS_UPDATED;
        } else {
            return USERS_UPDATE_FAILED;
        }
    }

    // get student class history
    public function getUsersWithId()
    {
        $stmt = $this->con->prepare(
            'SELECT id	,fname,	lname,	email,	contact,	user_type,	password,createdby, created, modifiedby, modified FROM ' .
                $this->tbusers .
                ' WHERE id = ?'
        );

        $this->id = $this->sanitizeInput(
            'users Id',
            $this->id,
            INTEGER
        );
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->bind_result(
            $id,
            $fname,
            $lname,
            $email,
            $contact,
            $user_type,
            $password,
            $createdby,
            $created,
            $modifiedby,
            $modified
        );
        $stmt->store_result();
        $stmt->fetch();

        $user = [];
        $user['id'] = $id;
        $user['fname'] = $fname;
        $user['lname'] = $lname;
        $user['email'] = $email;
        $user['contact'] = $contact;
        $user['user_type'] = $user_type;
        $user['password'] = $password;

        return $user;
    }



    //function to get a PROJECT by id
    function getProjectById()
    {
        $stmt = $this->con->prepare(
            'SELECT id, name, project_type_id,user_id, created_by, created, modified_by, smodified FROM ' .
                $this->tbPro .
                ',  ' .
                ' WHERE  ' .
                $this->tbPro .
                '.scid = '
        );
        $this->id = $this->sanitizeInput('project id', $this->id, INTEGER);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->bind_result(
            $id,

            $name,
            $project_type_id,
            $user_id,
            $screated_by,
            $screated,
            $smodified_by,
            $smodified
        );
        $stmt->store_result();
        $stmt->fetch();

        $Admin = [];
        $Admin['id'] = $id;
        $Admin['names'] = $name;
        $Admin['email'] = $project_type_id;
        $Admin['password'] = $user_id;

        return $Admin;
    }


    //Get Admin passsword by registration number
    function getAdminPassword()
    {
        $stmt = $this->con->prepare(
            'SELECT spassword FROM Admins WHERE email = ?'
        );
        $this->email = $this->sanitizeInput('email', $this->email, STRING);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $stmt->bind_result($spassword);
        $stmt->fetch();

        return $spassword;
    }

    //function to edit/update projects
    function updateProjects()
    {
        $stmt = $this->con->prepare(
            'UPDATE projects SET name=?, project_type_id=?, user_id=?, modified=?, modifiedby=? WHERE id = ?'
        );
        //sanitise input
        $this->name = $this->sanitizeInput(
            'name',
            $this->name,
            STRING
        );
        $this->project_type_id = $this->sanitizeInput(
            'project_type',
            $this->project_type_id,
            STRING
        );
        $this->user_id = $this->sanitizeInput(
            'user',
            $this->user_id,
            INTEGER
        );

        $this->modifiedby = $this->sanitizeInput(
            'Modified by',
            $this->modifiedby,
            INTEGER
        );
        $this->modified = $this->sanitizeInput(
            'Modified',
            $this->modified,
            STRING
        );

        $stmt->bind_param(
            'ssiis',
            $this->name,
            $this->project_type_id,
            $this->user_id,
            $this->modifiedby,
            $this->modified
        );

        if ($stmt->execute()) {
            return PROJECT_UPDATED;
        } else {
            return PROJECT_UPDATE_FAILED;
        }
    }

    //Check empty fields
    public function sanitizeInput(
        $fieldName,
        $value,
        $dataType,
        $required = true
    ) {
        if ($required && empty($value)) {
            echo "$fieldName is a required field.\n";
            exit();
        }

        switch ($dataType) {
            case BOOLEAN:
                if (!is_bool($value)) {
                    echo "$fieldName field has an invalid data type. It should be boolean.\n";
                    return;
                }
                break;
            case INTEGER:
                if (!is_numeric($value)) {
                    echo "$fieldName field has an invalid data type. It should be numeric.";
                    return;
                }
                break;
            case STRING:
                if (!is_string($value)) {
                    echo "$fieldName field has an invalid data type. It should be a string.";
                    return;
                }
                break;
            default:
                echo "$fieldName field has an invalid data type.";
                return;
        }
        $value = htmlspecialchars(strip_tags($value));
        return htmlspecialchars(strip_tags($value));
    }
    // function to get all schools
    public function getAllProjects()
    {
        $query = $this->con->prepare(
            'SELECT ID,	name,project_type_id,user_id,created,createdby,modifiedby,modified FROM ' .
                $this->tbPro
        );
        $query->execute();
        $query->bind_result(
            $ID,
            $name,
            $project_type_id,
            $user_id,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $projects = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $project = [];
                $project['sn'] = $sn;
                $project['id'] = $ID;
                $project['name'] = $name;
                $project['project_type_id'] = $project_type_id;
                $project['user_id'] = $user_id;
                $project['created'] = $created;
                $project['createdby'] = $createdby;
                $project['modifiedby'] = $modifiedby;
                $project['modified'] = $modified;

                array_push($projects, $project);
            }
            return $projects;
        } else {
            return 'No Schools found';
        }
    }


    public function getAllProjectTypes()
    {
        $query = $this->con->prepare(
            'SELECT ID, project_types, groups,individual, created, createdby, modified, modifiedby FROM ' .
                $this->tbprojecttypes
        );
        $query->execute();
        $query->bind_result(
            $ID,
            $project_types,
            $groups,
            $individual,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $projects = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $project = [];
                $project['sn'] = $sn;
                $project['ID'] = $ID;
                $project['project_types'] = $project_types;
                $project['groups'] = $groups;
                $project['individual'] = $individual;
                $project['created'] = $created;
                $project['createdby'] = $createdby;
                $project['modifiedby'] = $modifiedby;
                $project['modified'] = $modified;

                array_push($projects, $project);
            }
            return $projects;
        } else {
            return 'No Schools found';
        }
    }

    public function getAllProjectMarks()
    {
        $query = $this->con->prepare(
            'SELECT ID,pro_details_id, marks,created, createdby, modified, modifiedby FROM ' .
                $this->tbprojectmarks
        );
        $query->execute();
        $query->bind_result(
            $ID,
            $pro_details_id,
            $marks,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $projects = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $project = [];
                $project['sn'] = $sn;
                $project['ID'] = $ID;
                $project['proj_details_id'] = $pro_details_id;
                $project['marks'] = $marks;
                $project['created'] = $created;
                $project['createdby'] = $createdby;
                $project['modifiedby'] = $modifiedby;
                $project['modified'] = $modified;

                array_push($projects, $project);
            }
            return $projects;
        } else {
            return 'No project marks found';
        }
    }


    //function to delete a projects
    public function deleteProject()
    {
        $stmt = $this->con->prepare('DELETE FROM projects WHERE id = ?');
        $this->id = $this->sanitizeInput('project id', $this->id, INTEGER);
        $stmt->bind_param('i', $this->id);

        if ($stmt->execute()) {
            return PROJECT_DELETED;
        } else {
            return PROJECT_DELETION_FAILED;
        }
    }

    // Check whether a project exists
    public function isProjectExist()
    {
        $stmt = $this->con->prepare(
            'SELECT name FROM  ' .
                $this->tbPro .
                ' WHERE project_type_id = ?'
        );
        //sanitize incoming data
        $this->project_type_id = $this->sanitizeInput(
            'project_type .',
            $this->project_type_id,
            INTEGER
        );

        $stmt->bind_param('s', $this->project_type_id);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    //Register a projects
    public function createProjects()
    {
        if (!$this->isProjectExist()) {
            $this->project_type_id = password_hash(
                $this->project_type_id,
                'PROJECT_DEFAULT'
            );

            $stmt = $this->con->prepare(
                'INSERT INTO ' .
                    $this->tbPro .
                    '(name, project_type_id, user_id,created_by,created) VALUES (?, ?, ?, ?, ? )'
            );

            //sanitize incoming data
            $this->name = $this->sanitizeInput(
                'name',
                $this->name,
                STRING
            );
            $this->project_type_id = $this->sanitizeInput(
                'project_type_id',
                $this->project_type_id,
                INTEGER
            );
            $this->user_id = $this->sanitizeInput(
                'subject_id ',
                $this->user_id,
                INTEGER
            );

            $this->createdby = $this->sanitizeInput(
                'Created by',
                $this->createdby,
                INTEGER
            );
            $this->created = $this->sanitizeInput(
                'Created on',
                $this->created,
                STRING
            );

            $stmt->bind_param(
                'siiis',
                $this->name,
                $this->project_type_id,
                $this->user_id,
                $this->createdby,
                $this->created
            );

            if ($stmt->execute()) {
                return PROJECT_CREATED;
            } else {
                return PROJECT_CREATION_FAILED;
            }
        } else {
            return PROJECT_EXISTS;
        }
    }
    //function to view project 
    public function viewProjects()
    {
        $stmt = $this->con->prepare(
            'SELECT id, name	,project_type_id,user_id, created, createdby, modified, modifiedby,FROM  ' .
                $this->tbprojectmarks .
                ',  ' .
                ' WHERE  ' .
                $this->tbprojectmarks .
                '.scid = '
        );
        $stmt->execute();
        $stmt->bind_result(
            $id,
            $name,
            $project_type_id,
            $user_id,
            $created,
            $createdby,
            $modified,
            $modified_by
        );
        $stmt->store_result();
        $projects = [];
        $sn = 0;
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $sn = $sn + 1;
                $project = [];
                $project['sn'] = $sn;
                $project['id'] = $id;
                $project['name	'] = $name;
                $project['project_type_id'] = $project_type_id;
                $project['user_id'] = $user_id;
                array_push($projects, $project);
            }
            return $projects;
        } else {
            return 'No results';
        }
    }
    //function to edit/update results
    public function updateResult()
    {
        $stmt = $this->con->prepare(
            'UPDATE results SET subj_id = ?,stud_id = ?,mark = ?, modified = ?,  modifiedby = ?  WHERE id = ?'
        );
        //sanitise inputid		
        $this->subj_id = $this->sanitizeInput(
            'subject id',
            $this->subj_id,
            INTEGER
        );
        $this->stud_id = $this->sanitizeInput(
            'student id',
            $this->stud_id,
            INTEGER
        );
        $this->marks = $this->sanitizeInput(
            'marks ',
            $this->marks,
            INTEGER
        );
        $this->modified = $this->sanitizeInput(
            'Modified',
            $this->modified,
            STRING
        );
        $this->modifiedby = $this->sanitizeInput(
            'ModifiedBy',
            $this->modifiedby,
            INTEGER
        );
        $this->id = $this->sanitizeInput('Result id', $this->id, 'INTEGER');

        $stmt->bind_param(
            'iisi',
            $this->subj_id,
            $this->stud_id,
            $this->mark,
            $this->modified,
            $this->modifiedby,
            $this->id
        );
        if ($stmt->execute()) {
            return RESULT_UPDATED;
        } else {
            return RESULT_UPDATE_FAILED;
        }
    }

    //function to create project type
    public function createProjectType()
    {

        $stmt = $this->con->prepare(
            'INSERT INTO ' .
                $this->tbprojecttypes .
                '(project_types,groups,individual,created, createdby) VALUES (?, ?,?,?,?)'
        );

        //sanitize incoming data
        $this->project_types = $this->sanitizeInput(
            'Project Type',
            $this->project_types,
            STRING
        );
        $this->groups = $this->sanitizeInput(
            'group',
            $this->groups,
            INTEGER
        );
        $this->individual = $this->sanitizeInput(
            'individual',
            $this->individual,
            STRING
        );
        $this->created = $this->sanitizeInput(
            'Created on',
            $this->created,
            STRING
        );
        $this->createdby = $this->sanitizeInput(
            'CreatedBy',
            $this->createdby,
            INTEGER
        );

        $stmt->bind_param(
            'sissi',
            $this->project_types,
            $this->groups,
            $this->individual,
            $this->created,
            $this->createdby
        );

        if ($stmt->execute()) {
            return PROJECTTYPE_CREATED;
        } else {
            return PROJECTTYPE_CREATE_FAILED;
        }
    }
    //function to view project type
    // public function getProjectType()
    // {
    //     $stmt = $this->con->prepare(
    //         'SELECT id, name,group, individual, created, createdby, modified, modifiedby,FROM  ' .
    //             $this->tbprojecttypes .
    //             ',  ' .
    //             ' WHERE  ' .
    //             $this->tbprojecttypes .
    //             '.scid = '
    //     );
    //     $stmt->execute();
    //     $stmt->bind_result(
    //         $id,
    //         $name,
    //         $groups,
    //         $individual,
    //         $created,
    //         $createdby,
    //         $modified,
    //         $modified_by
    //     );
    //     $stmt->store_result();
    //     $projects = [];
    //     $sn = 0;
    //     if ($stmt->num_rows > 0) {
    //         while ($stmt->fetch()) {
    //             $sn = $sn + 1;
    //             $project = [];
    //             $project['sn'] = $sn;
    //             $project['id'] = $id;
    //             $project['name'] = $name;
    //             $project['group'] = $groups;
    //             $project['individual'] = $individual;

    //             array_push($projects, $project);
    //         }
    //         return $projects;
    //     } else {
    //         return 'No results';
    //     }
    // }
    //function to update project type
    // public function updateProjectType()
    // {

    //     $stmt = $this->con->prepare(
    //         'UPDATE project_type SET project_types=?, groups =?, individual=?, modified=?, modifiedby=? WHERE ID = ?'
    //     );
    //     //sanitise input
    //     $this->project_types = $this->sanitizeInput(
    //         'Project Type',
    //         $this->project_types,
    //         STRING
    //     );
    //     $this->groups = $this->sanitizeInput(
    //         'group',
    //         $this->groups,
    //         STRING
    //     );
    //     $this->individual = $this->sanitizeInput(
    //         'Individual',
    //         $this->individual,
    //         STRING
    //     );

    //     $this->modifiedby = $this->sanitizeInput(
    //         'Modified by',
    //         $this->modifiedby,
    //         INTEGER
    //     );
    //     $this->modified = $this->sanitizeInput(
    //         'Modified',
    //         $this->modified,
    //         STRING
    //     );

    //     $stmt->bind_param(
    //         'ssis',
    //         $this->project_types,
    //         $this->groups,
    //         $this->individual,
    //         $this->modifiedby,
    //         $this->modified
    //     );

    //     if ($stmt->execute()) {
    //         return PROJECTTYPE_UPDATED;
    //     } else {
    //         return PROJECTTYPE_UPDATE_FAILED;
    //     }
    // }

    //function to delete project type
    public function deleteProjectType()
    {

        $stmt = $this->con->prepare('DELETE FROM project_type WHERE ID = ? ');
        $this->ID = $this->sanitizeInput('Project Type Id', $this->ID, INTEGER);
        $stmt->bind_param('i', $this->ID);

        if ($stmt->execute()) {
            return PROJECTTYPE_DELETED;
        } else {
            return PROJECTTYPE_DELETION_FAILED;
        }
    }

    // //function to create project details
    public function createProjectDetails()
    {
        $stmt = $this->con->prepare(
            'INSERT INTO ' .
                $this->tbprojectdetails .
                '(pid,result_id		,image,student_id,description, created, createdby) VALUES (?,?,?,?,?,?,?)'
        );

        //sanitize incoming data
        $this->pid = $this->sanitizeInput(
            'pid',
            $this->pid,
            INTEGER
        );
        $this->result_id         = $this->sanitizeInput(
            'result_id		',
            $this->result_id,
            INTEGER
        );
        $this->image = $this->sanitizeInput(
            'image',
            $this->image,
            'BLOB'
        );
        $this->stud_id     = $this->sanitizeInput(
            'stud_id	',
            $this->stud_id,
            INTEGER
        );
        $this->description = $this->sanitizeInput(
            'description',
            $this->description,
            STRING
        );
        $this->created = $this->sanitizeInput(
            'Created on',
            $this->created,
            STRING
        );
        $this->createdby = $this->sanitizeInput(
            'CreatedBy',
            $this->createdby,
            INTEGER
        );

        $stmt->bind_param(
            'iibissi',
            $this->pid,
            $this->result_id,
            $this->image,
            $this->stud_id,
            $this->description,
            $this->created,
            $this->createdby
        );

        if ($stmt->execute()) {
            return PROJECTDETAILS_CREATED;
        } else {
            return PROJECTDETAILS_CREATE_FAILED;
        }
    }

    //function to view project details
    public function viewProjectDetails()
    {
        $stmt = $this->con->prepare(
            'SELECT id, pid,result_id		, image,stud_id	,description, created, createdby, modified, modifiedby,FROM  ' .
                $this->tbprojectdetails .
                ',  ' .
                ' WHERE  ' .
                $this->tbprojectdetails .
                '.scid = '
        );
        $stmt->execute();
        $stmt->bind_result(
            $id,
            $pid,
            $result_id,
            $image,
            $stud_id,
            $description,
            $created,
            $createdby,
            $modified,
            $modified_by
        );
        $stmt->store_result();
        $projects = [];
        $sn = 0;
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $sn = $sn + 1;
                $project = [];
                $project['sn'] = $sn;
                $project['id'] = $id;
                $project['pid'] = $pid;
                $project['result_id		'] = $result_id;
                $project['image'] = $image;
                $project['stud_id	'] = $stud_id;
                $project['description'] = $description;

                array_push($projects, $project);
            }
            return $projects;
        } else {
            return 'No results';
        }
    }

    // function update project details
    public function updateProjectDetails()
    {
        $stmt = $this->con->prepare(
            'UPDATE project_details SET pid=?, result_id		=?, image=?,stud_id	=?,description=?, modified=?, modifiedby=? WHERE id = ?'
        );
        //sanitise input
        $this->pid = $this->sanitizeInput(
            'pid',
            $this->pid,
            INTEGER
        );
        $this->result_id         = $this->sanitizeInput(
            'result_id		',
            $this->result_id,
            INTEGER
        );
        $this->image = $this->sanitizeInput(
            'image',
            $this->image,
            STRING
        );
        $this->stud_id     = $this->sanitizeInput(
            'stud_id	',
            $this->stud_id,
            INTEGER
        );
        $this->description = $this->sanitizeInput(
            'description',
            $this->description,
            STRING
        );

        $this->modifiedby = $this->sanitizeInput(
            'Modified by',
            $this->modifiedby,
            INTEGER
        );
        $this->modified = $this->sanitizeInput(
            'Modified',
            $this->modified,
            STRING
        );

        $stmt->bind_param(
            'iibisis',
            $this->pid,
            $this->result_id,
            $this->image,
            $this->stud_id,
            $this->description,
            $this->modifiedby,
            $this->modified
        );

        if ($stmt->execute()) {
            return PROJECTDETAILS_UPDATED;
        } else {
            return PROJECTDETAILS_UPDATE_FAILED;
        }
    }

    //function to delete project details
    public function deleteProjectDetails()
    {
        $stmt = $this->con->prepare('DELETE FROM project_details WHERE id = ?');
        $this->id = $this->sanitizeInput('result id', $this->id, 'INTEGER');
        $stmt->bind_param('i', $this->id);

        if ($stmt->execute()) {
            return RESULT_DELETED;
        } else {
            return RESULT_DELETION_FAILED;
        }
    }

    // function to create projectmarks
    public function createProjectMarks()
    {
        $stmt = $this->con->prepare(
            'INSERT INTO ' .
                $this->tbprojectmarks .
                '(pro_details_id,marks, created, createdby) VALUES (?,?,?,?)'
        );

        //sanitize incoming data
        $this->pro_details_id = $this->sanitizeInput(
            'projdetailsid',
            $this->pro_details_id,
            INTEGER
        );
        $this->marks = $this->sanitizeInput(
            'marks',
            $this->marks,
            STRING
        );
        $this->created = $this->sanitizeInput(
            'Created on',
            $this->created,
            STRING
        );
        $this->createdby = $this->sanitizeInput(
            'CreatedBy',
            $this->createdby,
            INTEGER
        );

        $stmt->bind_param(
            'issi',
            $this->pro_details_id,
            $this->marks,
            $this->created,
            $this->createdby
        );

        if ($stmt->execute()) {
            return PROJECTMARKS_CREATED;
        } else {
            return PROJECTMARKS_CREATE_FAILED;
        }
    }

    //function to view project marks
    public function viewProjectMarks()
    {
        $stmt = $this->con->prepare(
            'SELECT id, pro_details_id	,marks, created, createdby, modified, modifiedby,FROM  ' .
                $this->tbprojectmarks .
                ',  ' .
                ' WHERE  ' .
                $this->tbprojectmarks .
                '.scid = '
        );
        $stmt->execute();
        $stmt->bind_result(
            $id,
            $pro_details_id,
            $marks,
            $created,
            $createdby,
            $modified,
            $modified_by
        );
        $stmt->store_result();
        $projects = [];
        $sn = 0;
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $sn = $sn + 1;
                $project = [];
                $project['sn'] = $sn;
                $project['id'] = $id;
                $project['pro_details_id	'] = $pro_details_id;
                $project['marks'] = $marks;
                array_push($projects, $project);
            }
            return $projects;
        } else {
            return 'No results';
        }
    }

    //function to update project marks
    public function updateProjectMarks()
    {
        $stmt = $this->con->prepare(
            'UPDATE project_marks SET pro_details_id	=?, marks=?, modified=?, modifiedby=? WHERE id = ?'
        );
        //sanitise input
        $this->pro_details_id     = $this->sanitizeInput(
            'pro_details_id	',
            $this->pro_details_id,
            INTEGER
        );
        $this->marks = $this->sanitizeInput(
            'marks',
            $this->marks,
            INTEGER
        );

        $this->modifiedby = $this->sanitizeInput(
            'Modified by',
            $this->modifiedby,
            INTEGER
        );
        $this->modified = $this->sanitizeInput(
            'Modified',
            $this->modified,
            STRING
        );

        $stmt->bind_param(
            'isis',
            $this->pro_details_id,
            $this->marks,
            $this->modifiedby,
            $this->modified
        );

        if ($stmt->execute()) {
            return PROJECTMARKS_UPDATED;
        } else {
            return PROJECTMARKS_UPDATE_FAILED;
        }
    }

    // function to delete project marks
    public function deleteProjectMarks()
    {
        $stmt = $this->con->prepare('DELETE FROM projec_tmarks WHERE ID = ?');
        $this->ID = $this->sanitizeInput('result id', $this->ID, 'INTEGER');
        $stmt->bind_param('i', $this->ID);

        if ($stmt->execute()) {
            return PROJECTMARKS_DELETED;
        } else {
            return PROJECTMARKS_DELETION_FAILED;
        }
    }
}
