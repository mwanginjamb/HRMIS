<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'customer@softeboard.com',
    'senderEmail' => 'customer@softeboard.com',
    'senderName' => 'HRMIS mailer',
    'user.passwordResetTokenExpire' => 3600,
    'powered' => 'Iansoft Ltd',
    'NavisionUsername'=>'HP ELITEBOOK 840 G5',
    'NavisionPassword'=>'@francis123#',


    'NavTestApprover' => 'Approver',
    'NavTestApproverPassword' => '@Approver123',

    'server'=>'FRANCIS',//'app-svr-dev.rbss.com',//Navision Server
    'WebServicePort'=>'6047',//Nav server Port
    'ServerInstance'=>'DynamicsNAV90',//Nav Server Instance
    'CompanyName'=>'AAS%20HR%20test',//Nav Company,
    'CompanyNameStripped' => 'AAS HR test$',
    'ldPrefix'=>'francis',//ACTIVE DIRECTORY prefix
    'adServer' => 'KRB-SVR7.KRBHQS.GO.KE', //Active directory domain controller

    //sharepoint config
    'sharepointUrl' => 'https://ackads.sharepoint.com',
    'sharepointUsername' => 'francis@ackads.onmicrosoft.com',
    'sharepointPassword' => '@crm1220#*',
    'library' => 'Mydocs',
    'clientID' => '7e92ce54-e4bf-491a-bef6-eb94044ce297',
    'clientSecret' => 'Q6UJkB3bRlPkGBjWNgrQVCyyjL2vgi5rtP7THpLwJ+s=',

    'profileControllers' => [
        'applicantprofile',
        'experience',
        'qualification',
        'hobby',
        'language',
        'referee',
        'recruitment',
        'employeerequisition'
    ],
    'codeUnits' => [
        'Portal_Workflows', //50019
        'JobApplication', //50023
        'AppraisalWorkflow' => 'AppraisalWorkflow', //50020 np  not taken to live
        'PortalReports', //50021
    ],
    'ServiceName'=>[
        'purchaseDocumentLines'=>'purchaseDocumentLines',//6405
        'UserSetup' => 'UserSetup', //119

        'employeeCard' => 'employeeCard', //70335
        'employees' => 'employees', //70312

        'leaveApplicationList' => 'leaveApplicationList', // 71053
        'leaveApplicationCard' => 'leaveApplicationCard', //71075
        'leaveBalance' => 'leaveBalance',//71153
        'leaveTypes' => 'leaveTypes', //70045
        'leaveRecallCard' => 'leaveRecallCard',//71076
        'leaveRecallList' => 'leaveRecallList',//71077
        'activeLeaveList' => 'activeLeaveList',//69005

        'Approvals' => 'Approvals', //654---------------duplicated
        'ApprovalComments' => 'ApprovalComments', //660
        'RejectedApprovalEntries' => 'RejectedApprovalEntries', //50003

        'RequisitionEmployeeList' => 'RequisitionEmployeeList',//70029
        'RequisitionEmployeeCard' => 'RequisitionEmployeeCard',//70028
        'JobsList' => 'JobsList',//70009
        'JobsCard' => 'JobsCard',//70002
        'JobApplicantProfile' => 'JobApplicantProfile', //50001
        'applicantProfile' => 'applicantProfile',//50001
        'referees' => 'referees',//55060
        'applicantLanguages' => 'applicantLanguages', //55061
        'experience' => 'experience', //55062
        'hobbies' => 'hobbies', //55063
        'qualifications' => 'qualifications',//55064
        'JobResponsibilities' => 'JobResponsibilities',//69000 -->specs
        'JobRequirements' => 'JobRequirements', //69001 ---> specs
        'JobExperience' => 'JobExperience',//69004
        'HRqualifications' => 'HRqualifications', //5205
        'JobApplicantRequirementEntries' => 'JobApplicantRequirementEntries', //55065

        'Countries' => 'Countries', //10
        'Religion' => 'Religion', //70085

        //Appraisal--------------------------------------------------------------------------------
        'AppraisalRating' => 'AppraisalRating',//60023
        'AppraisalProficiencyLevel' => 'AppraisalProficiencyLevel', //60025
        'AppraisalList' => 'AppraisalList', //60007
        'AppraisalCard' => 'AppraisalCard',//60008
        'EmployeeAppraisalKPI' => 'EmployeeAppraisalKPI', //60010
        'SubmittedAppraisals' => 'SubmittedAppraisals', //60012 --->Not taken to live server
        'ApprovedAppraisals' => 'ApprovedAppraisals', //60013 --> Not taken to live server
        'MYAppraiseeList' => 'MYAppraiseeList',//60014 -->Not Taken to live server
        'MYSupervisorList' => 'MYSupervisorList',//60015 -->Not Taken to live server
        'MYApprovedList' => 'MYApprovedList',//60016 --> Not Taken to live server (MY CLOSED)
        'EYAppraiseeList' => 'EYAppraiseeList',//60017 -->Not Taken to live server
        'EYSupervisorList' => 'EYSupervisorList',//60018 -->Not Taken to live server
        'EYPeer1List' => 'EYPeer1List',//60019 -->Not Taken to live server
        'EYPeer2List' => 'EYPeer2List',//60020 -->Not Taken to live server
        'EYAgreementList' => 'EYAgreementList',//60021 -->Not Taken to live server
        'ClosedAppraisalsList' => 'ClosedAppraisalsList',//60022 -->Not Taken to live server

        'AppraisalWorkflow' => 'AppraisalWorkflow', // 50020 ---> Code Unit : not published on live
        'PerformanceLevel' => 'PerformanceLevel',//60037 -> Not published on live

        'EmployeeAppraisalKRA' => 'EmployeeAppraisalKRA',//60009
        'TrainingPlan' => 'TrainingPlan', //60036
        'EmployeeAppraisalCompetence' => 'EmployeeAppraisalCompetence',//60033
        'EmployeeAppraisalBehaviours' => 'EmployeeAppraisalBehaviours', //60034
        'LearningAssessmentCompetence' => 'LearningAssessmentCompetence', //60035


        //Payslip report
        'PortalReports' => 'PortalReports',//50021
        'Payrollperiods' => 'Payrollperiods', //70255

        //P9 report

        'P9YEARS' => 'P9YEARS', //70286









        //Approval code unit
        'Portal_Workflows' => 'Portal_Workflows', //50019

        //Job Application Code Unit
        'JobApplication' => 'JobApplication', //50023

        /* Request to Approve */
        'RequeststoApprove' => 'RequeststoApprove', //654
    ],
    'QualificationsMimeTypes' => [

        'application/pdf',

    ],
    'Microsoft' => [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'application/vnd.ms-word.document.macroEnabled.12',
        'application/vnd.ms-word.template.macroEnabled.12',
        'application/vnd.ms-excel',
        'application/vnd.ms-excel',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.ms-excel.template.macroEnabled.12',
        'application/vnd.ms-excel.addin.macroEnabled.12',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.openxmlformats-officedocument.presentationml.template',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'application/vnd.ms-access',
        'application/rtf',
        'application/octet-stream'
    ]

];
