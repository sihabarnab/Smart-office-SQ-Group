<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>

    <style>

        * {
            --dark: #393939;
            --red: #d12229;
            --blue: rgb(80, 80, 236);

        }

        body {
            margin: 0;
            font-family: Roboto, Arial, Helvetica, sans-serif;
            position: relative;
            align-items: center;
            min-height: 100vh;
            justify-content: center;
        }

     /*   .id_card {
            display: flex;
            align-items: center;
            min-height: 100vh;
            justify-content: center;
            background-color: #131417;


        }*/

        .id_card .front,
        .id_card .back {
           
            width: 204.5px;
            height: 325px;
            margin: 0px;
            overflow: hidden;
            position: relative;
            background-size: cover;
            background-image: url(../../../docupload/sqgroup/DK6A7692.JPG);
            /*background: #000046;*/
            /*background: -webkit-linear-gradient(-45deg, #1CB5E0, #000046);*/
            /*background: linear-gradient(-45deg, #1CB5E0, #000046);*/
        }

        .department {
            position: absolute;
            width: 305px;
            transform: rotate(-90deg);
            color: white;
            top: 46%;
            right: 11%;
            padding: 7px 15px;
            background-color: #cc6633;
        }
        .department p{
            text-align: center;
            font-weight: 600;
            font-size:18px!important;
        }

        .company {
            position: absolute;
            width: 175px;
            color: #000;
            padding: 7px 0px;
            background-color: white;
            bottom: 5%;
            left: 16%;
        }
        .company p{
            color: #000!important;
            font-size:13px!important;
            font-weight: 500;
            text-align: center;
        }



        .id_card h1,
        .id_card h2,
        .id_card p {
            margin: 0;
            color: #eee;

        }

        .id_card p {
            margin: 0;
            color: #eee;
            font-size: 13px;

        }

        .id_card .head {
            display: flex;
            justify-content: center;
            padding: 25px 0;
        }

        .id_card .head img {
            width: 150px;
            margin-left: 40px;
        }

        .id_card .head>div {
            text-align: center;
            margin: 0 10px;
            text-transform: uppercase;
        }

        .id_card .avatar {
            position: absolute;
            width: 70%;
            left: 57%;
            top: 58px;
            transform: translate(-50%);
            text-align: center;
        }

        .id_card .img {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .id_card .img img {
            width: 60%;
            padding: 10px 0;
        }

        .id_card .avatar p:nth-of-type(1) {
            font-weight: 500;
            width: 100%;
            font-size: 13px;
        }


        @media print {


            .id_card .front,
            .id_card .back {

                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body class="id_card">

    @php
        $employee_info = DB::table('pro_employee_info')->where('employee_id', $employee_id)->first();
        $id = $employee_info->employee_id;
        $name = $employee_info->employee_name;

        $imageurl="../../../docupload/sqgroup/imagehrm";

        $biodata = DB::table('pro_employee_biodata')->where('employee_id', $employee_id)->first();
        // dd($biodata);
        $profile_pic = $biodata->emp_pic == NULL ? "$imageurl/profile/avatar.png" : "$imageurl/profile/$biodata->emp_pic";
        // $profile_pic = 'public/image/profile/avatar.png';


// $profile_pic = '../../../docupload/sqgroup/imagehrm/profile/00000130.jpg';
        $desig = DB::table('pro_desig')
            ->where('desig_id', $employee_info->desig_id)
            ->first();
            $designation = $desig->desig_name;

        $blood = DB::table('pro_blood')
            ->where('blood_id', $employee_info->blood_group)
            ->first();
            $blood_group_name = $blood->blood_name;


        $dep = DB::table('pro_department')
            ->where('department_id', $employee_info->department_id)
            ->first();
            $department = $dep->department_name;

        $comp_name = DB::table('pro_company')
            ->where('company_id', $employee_info->company_id)
            ->first();
            $company = $comp_name->company_name;
    @endphp
        <div class="front">
            <div class="head">
                <img src="{{ asset('public') }}/dist/img/SQ-Group-Logo-1.png" alt="logo">
            </div>

            <div class="avatar">
                <div class="img">
                    <img src="{{ asset("$profile_pic") }}" alt="profile">
                </div>
                <p>{{$name}}</p>
                <p>{{$designation}}</p>
                <p>Blood Group: {{$blood_group_name}}</p>
                <P>ID NO - {{$id}}</P>
            </div>
            <div class="department"><p>{{$department}}</p></div>
            <div class="company">
                <p>{{$company}}</p>
            </div>

        </div>

    {{--  <div class="id_card">
        <div class="front">
            <div class="head">
                <img src="{{ asset('public') }}/dist/img/SQ-Group-Logo-1.png" alt="logo">
            </div>

            <div class="avatar">
                <div class="img">
                    <img src="{{ asset("$profile_pic") }}" alt="profile">
                </div>
                <p>{{$name}}</p>
                <p>{{$designation}}</p>
                <p>Blood Group: {{$blood_group_name}}</p>
                <P>ID NO - {{$id}}</P>
            </div>
            <div class="department"><p>{{$department}}</p></div>
            <div class="company">
                <p>{{$company}}</p>
            </div>
        </div>

    </div> --}}
</body>

</html>
