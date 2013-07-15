<?php
/*
 * role => array(models => array( methods ))
 * 
 * 
 * */
	$config['AUTH'] = array
	(
		//超級管理員
		"0" 		=> array(	"login"		=>	array(	"index",
														"login",
														"logout",
														"getSessionValue"
														),
								"home"		=>	array(),
								"member"	=>	array(	"index"			,
														"edit"			,
														"create"		,
														"manage"		,
														"selectSchoolOption",
														"selectClassOption"	,
														"insertCity"	,
														"insertSchool"	,
														"insertClass"	,
														"insertUser"	,
														"findUserRank"
														),
								"exam"		=>	array(	"index",
														"findChild",
														"countQuizTotal",
														"countQuizOpen",
														"countQuizScore",
														"lockToggle",
														"closePractice",
														"sentOpen"
														),
								"mExam"		=>	array(	"index",
														"getNodeMes",
														"findChild",
														"showTemplate",
														"addQuestion",
														"findExamList",
														"findQuizMeta",
														"delQuiz",
														"editQuiz",
														"editOption",
														"editQuizTemplate",
														"showTinymce"														
														),
								"practice"	=>	array(	"index",
														"countQuizScore",
														"findChild",
														"countExam",
														"countAns",
														"findExamList",
														"addAnswer",
														"resultRoute",
														"result",
														"quizToArray",
														"findTips",
														"reStart"
														),
								"map"		=>	array(	"index",
														"map",
														"addNode",
														"readNode",
														"updNode",
														"delNode",
														"delLink",
														"kmList",
														"manage",
														"create",
														"insertSub"
														),
								"news"      =>  array(  "index",
								                        "read",
								                        "download",
								                        "manage",
								                        "add",
								                        "edit",
								                        "delete",
								                        "delete_file"
								                        )								
							),
		//一般管理員
		"1" 		=> array(	"login"		=>	array(	"index",
														"login",
														"logout",
														"getSessionValue"),
								"home"		=>	array(),
								"member"	=>	array(	"index",
														"edit",
														"create",
														"manage",
														"selectSchoolOption",
														"selectClassOption",
														"insertCity",
														"insertSchool",
														"insertClass",
														"insertUser",
														"findUserRank"),
								"exam"		=>	array(	"index",
														"findChild",
														"countQuizTotal",
														"countQuizOpen",
														"countQuizScore",
														"lockToggle",
														"closePractice",
														"sentOpen"),
								"mExam"		=>	array(	"index",
														"getNodeMes",
														"findChild",
														"showTemplate",
														"addQuestion",
														"findExamList",
														"findQuizMeta",
														"delQuiz",
														"editQuiz",
														"editOption",
														"editQuizTemplate",
														"showTinymce"														
														),
								"practice"	=>	array(	"index",
														"countQuizScore",
														"findChild",
														"countExam",														
														"countAns",
														"findExamList",
														"addAnswer",
														"resultRoute",
														"result",
														"quizToArray",
														"findTips",
														"reStart"),
								"map"		=>	array(	"index",
														"addNode",
														"map",
														"readNode",
														"updNode",
														"delNode",
														"delLink",
														"kmList",
														"manage",
														"create",
														"insertSub"
														)								
							),
		//老師
		"2" 		=> array(	"login"		=>	array(	"index",
														"login",
														"logout",
														"getSessionValue"),
								"home"		=>	array(),
								"member"	=>	array(	"index",
														"edit",
														"create",
														"manage",
														"selectSchoolOption",
														"selectClassOption",
														"insertCity",
														"insertSchool",
														"insertClass",
														"insertUser",
														"findUserRank"),
								"exam"		=>	array(	"index",
														"findChild",
														"countQuizTotal",
														"countQuizOpen",
														"countQuizScore",
														"lockToggle",
														"closePractice",
														"sentOpen"),
								"mExam"		=>	array(	"index",
														"getNodeMes",
														"findChild",
														"showTemplate",
														"addQuestion",
														"findExamList",
														"findQuizMeta",
														"delQuiz",
														"editQuiz",
														"editOption",
														"editQuizTemplate",
														"showTinymce"														
														),
								"practice"	=>	array(	"index",
														"countQuizScore",
														"findChild",
														"countExam",
														"countAns",
														"findExamList",
														"addAnswer",
														"resultRoute",
														"result",
														"quizToArray",
														"findTips",
														"reStart"),
								"map"		=>	array(	"index",
														"addNode",
														"map",
														"readNode",
														"updNode",
														"delNode",
														"delLink",
														"kmList",
														"manage",
														"create",
														"insertSub"
														)								
							),
		//學生
		"3" 		=> array(	"login"		=>	array(	"index",
														"login",
														"logout",
														"getSessionValue"),
								"home"		=>	array(),
								"exam"		=>	array(	"index",
														"findChild",
														"countQuizTotal",
														"countQuizOpen",
														"countQuizScore",
														"lockToggle",
														"closePractice",
														"sentOpen"),
								"practice"	=>	array(	"index",
														"countQuizScore",
														"findChild",
														"countExam",
														"countAns",
														"findExamList",
														"addAnswer",
														"resultRoute",
														"result",
														"quizToArray",
														"findTips",
														"reStart"),
								"map"		=>	array(	"index",
														"addNode",
														"map",
														"readNode",
														"updNode",
														"delNode",
														"delLink",
														"kmList")								
							),
		//訪客
		"4" 		=> array(	"login"		=>	array(	"index",
														"login",
														"logout")
								
							
							)
	);
	