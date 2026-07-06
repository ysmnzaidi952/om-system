<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =========================================================
        // ADMIN USERS
        // =========================================================
        
        // 1) Staff Member 1 (Super Admin - YOU)
        User::create([
            'ic'                     => '000000000001',
            'name'                   => 'Staff Member 1',
            'email'                  => 'staff1@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'admin',
            'status'                 => 'active',
            'date_joined'            => '2020-07-16',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => null,
            'position'               => 'Project/Operation Manager',
            'academic_qualification' => null,
            'years_of_experience'    => null,
            'epf_number'             => null,
            'phone_number'           => '0100000001',
            'secondary_phone_number' => null,
            'bank_name'              => null,
            'bank_account_number'    => null,
            'ic_address'             => null,
            'current_address'        => null,
        ]);

        // 2) Staff Member 2 (Admin - IBN HQ)
        User::create([
            'ic'                     => '000000000002',
            'name'                   => 'Staff Member 2',
            'email'                  => 'staff2@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'admin',
            'status'                 => 'active',
            'date_joined'            => null,
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'IBN HQ',
            'position'               => 'Project/Operation Manager',
            'academic_qualification' => 'Bachelor in Business Administration (Hons) International Business',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000001',
            'phone_number'           => '0100000002',
            'secondary_phone_number' => '0100000001',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 1, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 1, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 3) Staff Member 3 (Admin - KONTRAK)
        User::create([
            'ic'                     => '000000000003',
            'name'                   => 'Staff Member 3',
            'email'                  => 'staff3@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'admin',
            'status'                 => 'active',
            'date_joined'            => '2025-07-28',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Assistant Operation Manager',
            'academic_qualification' => 'Bachelor in Office Systems Management (Hons)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000002',
            'phone_number'           => '0100000003',
            'secondary_phone_number' => '0100000002',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 2, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 2, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // =========================================================
        // STAFF - CUSTOMER SUPPORT ENGINEERS
        // =========================================================

        // 4) Staff Member 4
        User::create([
            'ic'                     => '000000000004',
            'name'                   => 'Staff Member 4',
            'email'                  => 'staff4@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2024-05-13',
            'date_confirmed'         => '2024-11-13',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Diploma of Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000003',
            'phone_number'           => '0100000004',
            'secondary_phone_number' => '0100000003',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => '0000000001',
            'ic_address'             => 'No. 3, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 3, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 5) Staff Member 5 (Lead)
        User::create([
            'ic'                     => '000000000005',
            'name'                   => 'Staff Member 5',
            'email'                  => 'staff5@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Lead Customer Support Engineer',
            'academic_qualification' => 'Bachelor Of Science Computer (Software Engineering) with Honours',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000004',
            'phone_number'           => '0100000005',
            'secondary_phone_number' => '0100000004',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 4, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 4, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 6) Staff Member 6
        User::create([
            'ic'                     => '000000000006',
            'name'                   => 'Staff Member 6',
            'email'                  => 'staff6@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-02-03',
            'date_confirmed'         => '2025-07-03',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Bachelor Of Information Science (Hons.) Information System Management',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000005',
            'phone_number'           => '0100000006',
            'secondary_phone_number' => '0100000005',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 5, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 5, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 7) Staff Member 7
        User::create([
            'ic'                     => '000000000007',
            'name'                   => 'Staff Member 7',
            'email'                  => 'staff7@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2023-05-01',
            'date_confirmed'         => '2023-11-01',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Diploma Teknologi Maklumat',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000006',
            'phone_number'           => '0100000007',
            'secondary_phone_number' => '0100000006',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 6, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 6, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 8) Staff Member 8
        User::create([
            'ic'                     => '000000000008',
            'name'                   => 'Staff Member 8''name' => 'Staff Member 8',',
            'email'                  => 'staff8@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2024-04-25',
            'date_confirmed'         => '2024-10-25',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Diploma of Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000007',
            'phone_number'           => '0100000008',
            'secondary_phone_number' => '0100000007',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 7, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 7, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 9) Staff Member 9
        User::create([
            'ic'                     => '000000000009',
            'name'                   => 'Staff Member 9',
            'email'                  => 'staff9@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-06-03',
            'date_confirmed'         => '2025-09-03',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Bachelor of Computer Science (Hons.) in Computer Networks',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000008',
            'phone_number'           => '0100000009',
            'secondary_phone_number' => '0100000008',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 8, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 8, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 10) Staff Member 10
        User::create([
            'ic'                     => '000000000010',
            'name'                   => 'Staff Member 10',
            'email'                  => 'staff10@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2023-03-06',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Bachelor Of Computer Science (Computer Networks)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000009',
            'phone_number'           => '0100000010',
            'secondary_phone_number' => '0100000009',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 9, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 9, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 11) Staff Member 11
        User::create([
            'ic'                     => '000000000011',
            'name'                   => 'Staff Member 11',
            'email'                  => 'staff11@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-05-08',
            'date_confirmed'         => '2025-08-08',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Diploma of Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000010',
            'phone_number'           => '0100000011',
            'secondary_phone_number' => '0100000010',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 10, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 10, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 12) Staff Member 12
        User::create([
            'ic'                     => '000000000012',
            'name'                   => 'Staff Member 12',
            'email'                  => 'staff12@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-06-03',
            'date_confirmed'         => '2025-09-03',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Bachelor of Software Engineering',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000011',
            'phone_number'           => '0100000012',
            'secondary_phone_number' => '0100000011',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 11, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 11, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 13) Staff Member 13
        User::create([
            'ic'                     => '000000000013',
            'name'                   => 'Staff Member 13',
            'email'                  => 'staff13@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-07-14',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Customer Support Engineer',
            'academic_qualification' => 'Diploma in Science Computer',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000012',
            'phone_number'           => '0100000013',
            'secondary_phone_number' => null,
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 12, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 12, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // =========================================================
        // STAFF - APPLICATION SUPPORT ENGINEERS
        // =========================================================

        // 14) Staff Member 14 (Lead)
        User::create([
            'ic'                     => '000000000014',
            'name'                   => 'Staff Member 14',
            'email'                  => 'staff14@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Lead Application Support Engineer',
            'academic_qualification' => 'Diploma of Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000013',
            'phone_number'           => '0100000014',
            'secondary_phone_number' => '0100000012',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 13, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 13, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 15) Staff Member 15
        User::create([
            'ic'                     => '000000000015',
            'name'                   => 'Staff Member 15',
            'email'                  => 'staff15@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Bachelor of Engineering (Computer & Communication System)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000014',
            'phone_number'           => '0100000015',
            'secondary_phone_number' => '0100000013',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => '0000000002',
            'ic_address'             => 'No. 14, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 14, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 16) Staff Member 16
        User::create([
            'ic'                     => '000000000016',
            'name'                   => 'Staff Member 16',
            'email'                  => 'staff16@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Bachelor of Science Computer',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000015',
            'phone_number'           => '0100000016',
            'secondary_phone_number' => '0100000014',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 15, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 15, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 17) Staff Member 17
        User::create([
            'ic'                     => '000000000017',
            'name'                   => 'Staff Member 17',
            'email'                  => 'staff17@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2023-07-01',
            'date_confirmed'         => '2024-01-01',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Diploma In Science Computer',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000016',
            'phone_number'           => '0100000017',
            'secondary_phone_number' => '0100000015',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 16, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 16, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 18) Staff Member 18
        User::create([
            'ic'                     => '000000000018',
            'name'                   => 'Staff Member 18',
            'email'                  => 'staff18@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2023-06-01',
            'date_confirmed'         => '2023-12-01',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Diploma in Electronic Engineering (Communication)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000017',
            'phone_number'           => '0100000018',
            'secondary_phone_number' => '0100000016',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => '0000000003',
            'ic_address'             => 'No. 17, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 17, Jalan Demo, 43000 Kajang, Selangor' Abu Bakar Baginda, 43000 Kajang, Selangor',
        ]);

        // 19) Staff Member 19
        User::create([
            'ic'                     => '000000000019',
            'name'                   => 'Staff Member 19',
            'email'                  => 'staff19@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Bachelor Of Science (Hons) in Computer Science',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000018',
            'phone_number'           => '0100000019',
            'secondary_phone_number' => '0100000017',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 18, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 18, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 20) Staff Member 20
        User::create([
            'ic'                     => '000000000020',
            'name'                   => 'Staff Member 20',
            'email'                  => 'staff20@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Diploma In Network Security',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000019',
            'phone_number'           => '0100000020',
            'secondary_phone_number' => '0100000018',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => '0000000004',
            'ic_address'             => 'No. 19, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 19, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 21) Staff Member 21
        User::create([
            'ic'                     => '000000000021',
            'name'                   => 'Staff Member 21',
            'email'                  => 'staff21@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Diploma In Information Technology (Programming)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000020',
            'phone_number'           => '0100000021',
            'secondary_phone_number' => '0100000019',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 20, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 20, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 22) Staff Member 22
        User::create([
            'ic'                     => '000000000022',
            'name'                   => 'Staff Member 22',
            'email'                  => 'staff22@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-05-13',
            'date_confirmed'         => '2025-08-13',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Application Support Engineer',
            'academic_qualification' => 'Bachelor In Information Technology (Hons.) Information Systems Engineering',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000021',
            'phone_number'           => '0100000022',
            'secondary_phone_number' => '0100000020',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 21, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 21, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // =========================================================
        // STAFF - TECHNICAL SUPPORT ENGINEERS
        // =========================================================

        // 23) Staff Member 23 (Lead)
        User::create([
            'ic'                     => '000000000023',
            'name'                   => 'Staff Member 23',
            'email'                  => 'staff23@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Lead Technical Support Engineer',
            'academic_qualification' => 'Diploma in Computer Science and Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000022',
            'phone_number'           => '0100000023',
            'secondary_phone_number' => '0100000021',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 22, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 22, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 24) Staff Member 24
        User::create([
            'ic'                     => '000000000024',
            'name'                   => 'Staff Member 24',
            'email'                  => 'staff24@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-06-06',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Technical Support Engineer',
            'academic_qualification' => 'Bachelor Of Computer Science (Maritime Informatics)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000023',
            'phone_number'           => '0100000024',
            'secondary_phone_number' => '0100000022',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => '0000000005',
            'ic_address'             => 'No. 23, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 23, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 25) Staff Member 25
        User::create([
            'ic'                     => '000000000025',
            'name'                   => 'Staff Member 25',
            'email'                  => 'staff25@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2024-06-03',
            'date_confirmed'         => '2024-12-03',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Technical Support Engineer',
            'academic_qualification' => 'Diploma in Biomedical Electronics Engineering (ICT)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000024',
            'phone_number'           => '0100000025',
            'secondary_phone_number' => '0100000023',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => '0000000006',
            'ic_address'             => 'No. 24, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 24, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 26) Staff Member 26
        User::create([
            'ic'                     => '000000000026',
            'name'                   => 'Staff Member 26',
            'email'                  => 'staff26@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2024-08-15',
            'date_confirmed'         => '2025-02-15',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Technical Support Engineer',
            'academic_qualification' => 'Diploma in Biomedical Electronics Engineering (ICT)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000025',
            'phone_number'           => '0100000026',
            'secondary_phone_number' => '0100000024',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => '0000000007',
            'ic_address'             => 'No. 25, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 25, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 27) Staff Member 27
        User::create([
            'ic'                     => '000000000027',
            'name'                   => 'Staff Member 27',
            'email'                  => 'staff27@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-04-09',
            'date_confirmed'         => '2025-07-09',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Technical Support Engineer',
            'academic_qualification' => 'Diploma Kemahiran Malaysia',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000026',
            'phone_number'           => '0100000027',
            'secondary_phone_number' => '0100000025',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 26, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 26, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 28) Staff Member 28
        User::create([
            'ic'                     => '000000000028',
            'name'                   => 'Staff Member 28',
            'email'                  => 'staff28@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-06-03',
            'date_confirmed'         => '2025-09-03',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Technical Support Engineer',
            'academic_qualification' => 'Diploma in Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000027',
            'phone_number'           => '0100000028',
            'secondary_phone_number' => '0100000026',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 27, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 27, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // =========================================================
        // STAFF - SYSTEM SUPPORT ENGINEERS
        // =========================================================

        // 29) Staff Member 29 (Lead)
        User::create([
            'ic'                     => '000000000029',
            'name'                   => 'Staff Member 29',
            'email'                  => 'staff29@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Lead System Support Engineer',
            'academic_qualification' => 'Diploma of Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000028',
            'phone_number'           => '0100000029',
            'secondary_phone_number' => '0100000027',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 28, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 28, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 30) Staff Member 30
        User::create([
            'ic'                     => '000000000030',
            'name'                   => 'Staff Member 30',
            'email'                  => 'staff30@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-05-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'System Support Engineer',
            'academic_qualification' => 'Bachelor Of Computer Science (Computer System & Networking)',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000029',
            'phone_number'           => '0100000030',
            'secondary_phone_number' => '0100000028',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 29, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 29, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 31) Staff Member 31
        User::create([
            'ic'                     => '000000000031',
            'name'                   => 'Staff Member 31',
            'email'                  => 'staff31@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2023-06-06',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'System Support Engineer',
            'academic_qualification' => 'Diploma in Computer System And Networking',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000030',
            'phone_number'           => '0100000031',
            'secondary_phone_number' => '0100000029',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 30, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 30, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // =========================================================
        // STAFF - DATABASE ADMINISTRATOR
        // =========================================================

        // 32) Staff Member 32
        User::create([
            'ic'                     => '000000000032',
            'name'                   => 'Staff Member 32',
            'email'                  => 'staff32@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2025-05-26',
            'date_confirmed'         => '2025-08-26',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Database Administrator',
            'academic_qualification' => 'Ijazah Sarjana Muda Pengurusan Sistem dan Maklumat',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000031',
            'phone_number'           => '0100000032',
            'secondary_phone_number' => '0100000030',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 31, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 31, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // =========================================================
        // STAFF - NETWORK & SECURITY SUPPORT ENGINEERS
        // =========================================================

        // 33) Staff Member 33 (Lead)
        User::create([
            'ic'                     => '000000000033',
            'name'                   => 'Staff Member 33',
            'email'                  => 'staff33@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2021-12-21',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Lead Network & Security Support Engineer',
            'academic_qualification' => 'Bachelor of Computer Science (Computer Networking) with Honours',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000032',
            'phone_number'           => '0100000033',
            'secondary_phone_number' => '0100000031',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 32, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 32, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 34) Staff Member 34
        User::create([
            'ic'                     => '000000000034',
            'name'                   => 'Staff Member 34',
            'email'                  => 'staff34@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2024-03-01',
            'date_confirmed'         => '2024-09-01',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Network & Security Support Engineer',
            'academic_qualification' => 'Bachelor of Computer Engineering Technology (Networking Systems) With Honours',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000033',
            'phone_number'           => '0100000034',
            'secondary_phone_number' => '0100000032',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 33, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 33, Jalan Demo, 43000 Kajang, Selangor',
        ]);

        // 35) Staff Member 35
        User::create([
            'ic'                     => '000000000035',
            'name'                   => 'Staff Member 35',
            'email'                  => 'staff35@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'staff',
            'status'                 => 'active',
            'date_joined'            => '2023-03-06',
            'date_confirmed'         => '2023-09-06',
            'shirt_size'             => null,
            'staff_status'           => 'KONTRAK',
            'position'               => 'Network & Security Support Engineer',
            'academic_qualification' => 'Diploma of Information Technology',
            'years_of_experience'    => null,
            'epf_number'             => 'EPF000034',
            'phone_number'           => '0100000035',
            'secondary_phone_number' => '0100000033',
            'bank_name'              => 'Demo Bank',
            'bank_account_number'    => null,
            'ic_address'             => 'No. 34, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 34, Jalan Demo, 43000 Kajang, Selangor',
        ]);
                // =========================================================
        // INTERN - TEST USER
        // =========================================================

        // TEST INTERN
        User::create([
            'ic'                     => '000000000036',
            'name'                   => 'Staff Member 36',
            'email'                  => 'staff36@example.com',
            'password'               => Hash::make('password123'),
            'role'                   => 'intern',
            'status'                 => 'active',
            'date_joined'            => '2026-01-01',
            'date_confirmed'         => null,
            'shirt_size'             => null,
            'staff_status'           => 'INTERN',
            'position'               => 'Intern',
            'academic_qualification' => 'Pursuing Diploma in Computer Science',
            'years_of_experience'    => null,
            'epf_number'             => null,
            'phone_number'           => '0100000036',
            'secondary_phone_number' => null,
            'bank_name'              => null,
            'bank_account_number'    => null,
            'ic_address'             => 'No. 35, Jalan Demo, 43000 Kajang, Selangor',
            'current_address'        => 'No. 35, Jalan Demo, 43000 Kajang, Selangor',
            'internship_start_date'  => '2026-01-01',
            'internship_end_date'    => '2026-06-30',
        ]);
    }
}