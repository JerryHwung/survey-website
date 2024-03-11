<?php

// Things to notice:
// You need to add your Analysis and Design element of the coursework to this script
// There are lots of web-based survey tools out there already.
// It’s a great idea to create trial accounts so that you can research these systems. 
// This will help you to shape your own designs and functionality. 
// Your analysis of competitor sites should follow an approach that you can decide for yourself. 
// Examining each site and evaluating it against a common set of criteria will make it easier for you to draw comparisons between them. 
// You should use client-side code (i.e., HTML5/JavaScript/jQuery) to help you organise and present your information and analysis 
// For example, using tables, bullet point lists, images, hyperlinking to relevant materials, etc.

// execute the header script:
require_once "header.php";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
else
{
	echo <<<_END
	
	<h1 class='mt-5'>Survey Monkey <img src="img/surveymonkey-logo.png" alt="surveymonkey-logo" width="80" height="80"></h1>
	<h2>Layout/presentations of survey</h2>
	<p>All questions are shown in a single page, which you can select question by scrolling down if the survey
	doesn't require to answer a question before proceeding to another one.<br>
	Questions that are not selected will be dimmer but still visible.<br>
	Title and questions both are shown in bold and coloured so people tend to more focus on these things<br>
	</p>
	<h2>Ease of use</h2>
	<p>Many useful functions are provided to aid your survey making even for a free account.<br>
	An icon with an exclamation mark is provided to explain how a specific section works.<br>
	There is a help button on the right bottom corner to help you sort a specific problem.<br>
	Useful tools are easily to look for during survey creation.<br>
	Preview of survey in multiple platforms to make sure the layout doesn't look odd.<br>
	Customizable link and multiplatforms sharing.<br>
	Results can be export into different format(.PDF, .XLS, .CSV, .PPTX, or SPSS)[These is a paid feature].<br>
	<h2>User account set-up/Login process</h2>
	<p>Very easy to sign up, details other than username and passwords that required for sign up is first and last name. Other details
	can be added later.<br>
	Able to sign up with Google account, Facebook, Office 365 and LinkedIn too.<br>
	<h2>Question Type</h2>
	<p>Have a very wide range of questions in the question bank, they cover from casual just for fun surveys to benchmarkable business surveys.<br>
	The types are:<br>
	>Multiple Choice<br>>Checkboxes<br>>Image Choice<br>>Dropdown<br>>Star Rating<br>>Matrix/Rating Scale<br>
	>File upload<br>>Slider<br>>Matrix of Dropdown Menus<br>>Ranking<br>>Net Promoter® Score<br>>Single/Multiple textbox<br>
	>Comment box<br>>Contact information<br>>Date/Time<br>>Text<br>>Text/Image<br>>Text/Image A/B Test<br>
	They also do online polls.<br>
	<h2>Analysis tools</h2>
	<p>All general info are shown in the dashboard, like total responses, average completion rate and typical time spent etc.<br>
	Charts(customizable) are used to show the results after clicking a praticular survey.<br>
	Can apply filters or compare with other surveys in the result page.<br>
	<h2>Security & Privacy Policy</h2>
	<p>The data are secured by EU-U.S. Privacy Shield and Swiss-U.S. Privacy Shield.<br>
	Users have several rights:<br>
	>Data access rights<br>
	>Right to restrict processing<br>
	>Right of Rectification<br>
	>Right to Erasure (Right to be Forgotten)<br>
	>Right to object to processing<br>
	>Right to withdraw consent; and<br>
	>Data portability rights<br>
	More on <a href='https://www.surveymonkey.com/mp/legal/'>here</a>.<br>
	Certified by TRUSTe, accredited by BBB, and sites are secured by McAfee SECURE.<br>
	<h2>Review</h2>
	<p>Overall Survey Monkey is by far the most simple and user friendly site to create, manage and analyze surveys, casual users will find it easy to make their own simple yet elegant survey.</p>
	<h3><b>Pros</b></h3>
	<p>A very user friendly site to create and manage surveys. The colourful dashboard and interactive help buttons really did a great job at teaching first-time users how to operate their systems.<br>
	It also provide many varieties of question types even for a free account. Question recommendation from their question bank provides a very good head start if a user not sure how to make a survey for a specific topic.<br>
	<h3><b>Cons</b></h3>
	Since most of the survey is already set automatically there are not much customization can be made. Due to too many functions provided for user to edit their surveys sometimes is hard to find the desire function.<br>
	</p>
	
	<h1>Lime Survey <img src="img/Limesurvey_logo.png" alt="Limesurvey-logo" width="250" height="80"></h1>
	<h2>Layout/presentations of survey</h2>
	<p>Questions are subs of a question group, which is confusing at first.<br>
	Questions are split into one question per page.<br>
	A custom made welcome page and ending page.<br>
	Progression bar is shown at the top of the page.<br>
	Theme designs are very simple and limited for free user, hence the survey looks not very appealing.<br>
	<h2>Ease of use</h2>
	<p>Provides translations for surveys so the survey could easily understand by foreigner.<br>
	Able to import survey structure file (*.lss, *.txt) or survey archive(*.lsa) during survey creation.<br>
	Many tools to help survey creator to customize their survey, and most of the tools are listed on the page.
	Casual users might find it confusing when creating a survey at the first time.<br>
	Able to activate, deactivate and delete a survey and also set the survey as open-access or closed-access too.<br>
	<h2>User account set-up/Login process</h2>
	<p>Only username, password and email are needed to create an account, captcha also needed to submit the form.<br>
	Password and username validation is frustrating, but more secure.<br>
	Able to sign up with GitHub, Twitter and Google.<br>
	Creating a domain is required before creating a survey.<br>
	<h2>Question Type</h2>
	<p>Hard to find the question bank, and provide not much question type for casual user. Most of it are prone to help benchmarking business.Hence, the question designs have to start from scratch.<br>
	The major types are:<br>
	>Arrays<br>>Mask questions<br>>Multiple choice questions<br>>Single choice questions<br>>Text questions<br>
	<h2>Analysis tools</h2>
	<p>Mainly shows you a table of the results at the dashboard. Simple and easy to manage but not very pleasing to look at.<br>
	All results are showed as pie charts, bar graphs are used only for question type that is "Multiple Options".<br>
	The "incomplete responses", "no answers" and not "completed/not displayed" counts.<br>
	
_END;
}

// finish off the HTML for this page:
require_once "footer.php";
?>