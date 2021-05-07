<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'project' => [
        'title' => 'Projects',

        'actions' => [
            'index' => 'Projects',
            'create' => 'New Project',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'leader_id' => 'Leader',
            'name' => 'Name',
            'description' => 'Description',
            
        ],
    ],

    'timekeeping' => [
        'title' => 'Timekeeping',

        'actions' => [
            'index' => 'Timekeeping',
            'create' => 'New Timekeeping',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'timekeeping' => [
        'title' => 'Timekeeping',

        'actions' => [
            'index' => 'Timekeeping',
            'create' => 'New Timekeeping',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'project_id' => 'Project',
            'user_id' => 'User',
            'task' => 'Task',
            'description' => 'Description',
            'start_date' => 'Start date',
            'minutes' => 'Minutes',
            'location' => 'Location',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];