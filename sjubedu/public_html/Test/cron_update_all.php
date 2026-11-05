<?php
/**
 * bulk_import.php - CRON OPTIMIZED (ZERO DOWNTIME)
 */

set_time_limit(0); 
date_default_timezone_set('Asia/Kolkata');

// --- CONFIG & DB ---
$config = file_exists('/home/sjubedu/config.php') ? '/home/sjubedu/config.php' : __DIR__ . '/../../config.php';
require_once $config;

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Self-healing: Ensure api_cache table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `api_cache` (
      `id` varchar(255) PRIMARY KEY,
      `content` longtext NOT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `fail_count` int(11) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

} catch (Exception $e) { die("DB Error: " . $e->getMessage()); }

// --- 1. DATA ARRAY ---
$faculty_ids_to_load = [
    "171", // Fr. Victor Lobo S.J.
    "1293", // Jogith Biju Chungath
    "1710", // Nishmitha D Souza
    "1717", // Neil Shailon Fernandes
    "1", // Data Importer
    "2", // CYRIL
    "12", // Padma Nandanan K
    "18", // Dr. Syed Wajeed
    "20", // System Admin
    "30", // SATYASREE BALIJEPALLY
    "32", // Parul Goel
    "35", // POPY DUTTA
    "36", // Keshavamurthy K
    "37", // Shanty Mathew
    "39", // B. Nithya
    "49", // W. JOTHY
    "52", // Akshay Deepakrao Mandlik
    "58", // Shivakumar. K S
    "59", // RABBI AKKIBA ANGIRAS
    "60", // Mrinmoyee Bhattacharya
    "62", // A M Bojamma
    "64", // Lora Rita Goveas
    "69", // Veena Nirmala R
    "70", // CHRISTO SELVAN
    "73", // Immaculate Mary A
    "74", // Ahana Ruth Pinto
    "78", // Rajesh G
    "80", // C MARY MERLINE RANI
    "82", // SHALMALI DILIP KAMAT
    "84", // E BRUNO MARTIN
    "87", // Dr. SHOBHA S.V
    "89", // REGINA MATHIAS
    "90", // SANDHYA N
    "92", // Parvathy Poornima
    "97", // MAMATHA S
    "99", // SHEELA JOSE THOMAS
    "100", // BESSY ESTHELINE A
    "105", // DR MICHAEL RAJAMATHI R
    "106", // GRACE DIVYA D SOUZA
    "109", // Arun Varma Thampan
    "116", // Maruthu Pandiyan
    "120", // SANDIAGO
    "127", // MOHAN A
    "128", // Dr. MARIA ANNCY S
    "129", // MOHAMMAD AYESHA
    "134", // WILMA LAVEENA D'SOUZA
    "135", // Deepika S
    "140", // Dr  GODWIN   JACOB  D'  SOUZA
    "145", // GRACE PRABHAKAR
    "146", // Susan Mary Philip
    "147", // Poornima B. N
    "152", // SUNITA RAJAMANI
    "154", // A John Paul
    "155", // MARY PRINCESS LAVANYA
    "156", // Pathan Hasan Inus
    "158", // ANUPLAL GOPALAN
    "161", // Joyce Queeny D'souza
    "167", // PRASAD C N
    "174", // SUBIKSHALAKSHMI G
    "181", // GRACE LEENA CRASTA
    "183", // Dr. VAISHNAVI M
    "184", // POONAM R AHUJA
    "185", // PRATHIBHA
    "191", // TREESA JOY
    "192", // Archita N Murthy
    "193", // Prabhakar. K
    "194", // SARAH JOHN
    "195", // BANU M
    "199", // Nisha Menzies Rao
    "210", // VIJETA KUMAR
    "212", // NEVIL PRADEEP DSOUZA
    "214", // REV DR RICHARD REGO SJ
    "215", // Suhas D P
    "217", // Dr. MELWIN OLIVER COLACO
    "218", // Martin Paul A
    "222", // Bernard B Rodrigues
    "224", // SIMON PAUL D SOUZA
    "225", // AMITA PRIYADARSHINI
    "227", // POORNIMA S
    "228", // Eraiah
    "229", // Charles Ambrose A
    "232", // PRINCY NISHA D
    "233", // JAYATI BHADRA
    "234", // LAWERENCE RODRIGUES
    "236", // LEONARD WINSTON AIMAN
    "237", // CHAMPAKUMARI M
    "243", // Litty joseph
    "244", // Mohammed Umair
    "247", // Vidisha Madonna D'Souza
    "257", // MARIA  A
    "262", // Viyolla Pavana Mendonce
    "267", // Valeen Rashmi Pereira
    "268", // PARUL BATRA
    "270", // NEELAM MISHRA
    "271", // PARAMESHA M
    "272", // SANJAY DUTTA
    "274", // Issac C B
    "279", // Navya Dennis
    "285", // Nikhil Jha
    "296", // Tulika Bhattacharya
    "310", // Vanitha N M
    "331", // SAGAYANATHAN M
    "332", // RAMESHA M
    "336", // ANIL DSOUZA
    "337", // Gopal G
    "338", // EMILDA J DSOUZA
    "375", // Dr. DEBARATI CHATTOPADHYAY
    "387", // Jacob Paul V. J.
    "391", // RAJU M
    "413", // MOHANA DAS. C.
    "414", // Ronald Jerald Mascarenhas
    "415", // Libi Thomas
    "416", // Christine Elizabeth Nigli
    "436", // Niha Asif
    "437", // Sayantani Banerjee
    "441", // Parinitha Laxmi Ravishankar Shinde
    "444", // Avishek Suman
    "462", // Selwyn Paul J
    "493", // ETIENNE RASENDRAN
    "494", // Dr. MINI MARK BONJOUR
    "495", // ARUL MANI
    "497", // AMRITA BANERJEE
    "498", // Teena Ann Mathew
    "499", // Rency Litty Thomas
    "540", // Susobhan Mazumdar
    "541", // Raisa D'Souza
    "548", // BEATRICE MARIA  SEQUEIRA
    "571", // Dr. Karamala Areesh Kumar
    "582", // Viola Maria Noronha
    "583", // DR. ALAN GODFREY A
    "596", // Venkatesh D
    "598", // SUHAS S
    "600", // Adarsh  Raj
    "602", // JOHN CHRISTY
    "603", // BINOD KUMAR KAR
    "604", // SARAVANA
    "613", // M Jayashankar
    "635", // STEPHEN A
    "636", // ANAND
    "639", // Dr. B G PRASANTHI
    "640", // C A RODRIGUES MARIA SAHAYARAJ
    "642", // Fariyal Shaikh
    "643", // JANE JYOTHI DSOUZA
    "647", // Madappa Machamada Bheemaiah
    "650", // B S PRABHAKAR
    "651", // TANNEN NEIL LINCOLN
    "671", // VINAYA NAYAK MS
    "676", // SHASHIKALA.D
    "678", // P. SRIVIDYA
    "685", // Dr. Anitha.V
    "686", // Dr. NEETA GEROSA PEREIRA
    "687", // PRASANNA S B
    "696", // SRINIVAS BHOGLE
    "698", // RAJENDRA Y.J
    "700", // prt
    "701", // Michel .P
    "737", // R Suriya Narayanan
    "741", // Anchal Singhal
    "742", // G. Nalini
    "744", // S. Amudhan
    "745", // J Fathima Farzana
    "746", // Sana Begum M
    "747", // HARIHARAN R
    "748", // USHA PRIYADARSHINI S
    "756", // Maya Philip
    "759", // Dr.Hanumantharayappa.SB
    "762", // Shari Tess Mathew
    "763", // S. Rama Gokula Krishnan
    "764", // KAVYA K
    "766", // ROCHAK MITTAL
    "767", // SANJIVINI MAKNE
    "770", // AJAY CHANDRAN
    "774", // Admin
    "776", // G Lourdu Augustine
    "779", // SANDHYA CATHERINE
    "782", // Rahul Dev Raman A
    "789", // Mr. Philip Abraham.
    "799", // staff1
    "803", // Dr.BALAKRISHNA
    "806", // Praveen Paul
    "810", // JIMMY RALLYSON
    "814", // Drishti Rakhra
    "816", // Puneeth
    "818", // SHANTHAMMA B N
    "819", // MUNIYAMMA
    "820", // BALAMMA
    "821", // VELU
    "822", // Triveni
    "823", // BHARATHI
    "825", // RAVI
    "826", // PRAMOD
    "827", // RAMESH
    "828", // Chandrakala
    "829", // KAMALAKSHI
    "830", // Mary Catherine
    "831", // Mary Sandra
    "832", // M Indrani
    "833", // Panduranga
    "834", // RATNAMMA
    "837", // Suresh S
    "839", // M Ganesh
    "840", // Balraj
    "842", // Chandru
    "845", // Kavya C
    "846", // SAMPANGI N
    "847", // SAGAYA MARY L
    "848", // KANIKYARAJU
    "852", // Aloysius daniel crasta
    "854", // ANTHUVAN P K
    "855", // VEERA SEKARAN
    "856", // G Ramanjulu
    "857", // Thomas Paul
    "858", // KRISHNAIAH K
    "860", // PHILIP KUMAR C
    "861", // SAGAYANATHAN M
    "862", // Maria Susai P K
    "864", // Panchakshari N
    "865", // KASHIRAJ A
    "866", // Chandraiah  h k
    "867", // LAWARENCE M J
    "870", // JAYADEVA A
    "871", // Henry Goveas
    "872", // ANTHONY RAJU  D
    "873", // Manohar.d
    "874", // RAJKUMAR S
    "875", // MESHAK S
    "876", // DENNIS TAURO
    "877", // COLUMBUS STEPHEN
    "878", // M Shekar
    "879", // Magesh Rathnam
    "880", // ABRAHAM S
    "881", // Santhosh kumar
    "882", // PETER
    "883", // Ebenezer
    "884", // FRANCIS R
    "885", // Rekha K C
    "886", // BASAVARAJ
    "887", // SOWBHAGYA B
    "888", // Praveen.G
    "889", // SURESH K
    "890", // V TOKHO JOHN
    "891", // DHANAN JAYA H
    "892", // MALLANNA DEVOOR
    "893", // RAJA
    "899", // Richard Francis
    "900", // Newton K
    "903", // JOSEPH PINTO
    "905", // NAGAMANI
    "906", // MURALI
    "907", // Manjunath S
    "914", // Praveen Kumar Nagadesi
    "918", // SANJAY PRATYUSH
    "922", // Edmond Lewis
    "928", // Melissa C Remedios
    "930", // SIVAKANNAN S
    "931", // Puneeth Kumar B S
    "933", // Archana.V
    "939", // R. A. Daisy Singh
    "940", // P. ROCK RAMESH
    "942", // SUNITA ADAK
    "943", // Anupriya Mazumder
    "946", // Padmaja Pancharatnam
    "951", // Vinutha V Salian
    "952", // RITA PAL
    "960", // Gisa George
    "966", // Pramod P Harle
    "967", // VINAY BS
    "970", // FRANCIS DENSIL RAJ V
    "973", // Sreenivasulu Bandi
    "975", // Dr.Santosh Jagadeeshan
    "976", // Mohan Kumar S
    "985", // THEJASWINI G B
    "988", // Francis Pinto SJ
    "989", // RAJ KIRAN C A
    "993", // Paul Newman K
    "999", // NADIKA
    "1002", // Fr.DENZIL LOBO
    "1007", // Dr. A M ANTHONY JOHNSON
    "1008", // TESTADMISSION
    "1009", // Dr. VIGNESH G
    "1016", // Test
    "1019", // Mark Rasquinha
    "1026", // Reception
    "1027", // Nirmalya Basu
    "1029", // Sudha Praveen
    "1038", // Sch. Santhosh Kumar
    "1043", // Deepa Mathew
    "1051", // Ravinandan BB
    "1052", // Amutha Manavalan
    "1054", // ANUPAMA SHARMA
    "1056", // Shabin PK
    "1057", // JESHMA NISHITHA DSOUZA
    "1058", // Nigel George
    "1059", // Lillykutty Abraham
    "1061", // Anaurene Roy
    "1065", // Alisha C Ansari
    "1068", // Dyna Susan Thomas
    "1069", // GRACE PRERANA
    "1070", // Greeshma Francis
    "1072", // Raveender
    "1073", // Rahul Balu Varghese
    "1074", // Adwaith Rajesh
    "1075", // Mahesh Gowda
    "1076", // Rathan Gangadhar
    "1077", // GERARD ROZARIO J
    "1080", // Dr. Preethi Victor
    "1081", // Samson. S
    "1085", // ACHUTH A
    "1087", // Tobin Varkey Simson
    "1088", // Sathyanarayana R
    "1090", // Asha.K
    "1092", // Shakila. P
    "1094", // Sushmitha Vincent Chemmannoor
    "1095", // Teena Maria Rani
    "1100", // K S Narahari
    "1101", // Justin Johnson
    "1105", // Fr. Roshan Castelino SJ
    "1116", // Ms. Ann Irene
    "1118", // Report
    "1127", // Tejaswini Ronur Praful
    "1128", // Vereena Rodrigues
    "1130", // Pramod K M
    "1132", // Cisy Abraham
    "1133", // Reena Saritha Serrao
    "1135", // Ms Nirmala Rajah Cynthia
    "1138", // Shraddha K Namannavar
    "1139", // Sara Kutty T K
    "1140", // Kavya TH
    "1141", // Ms.Ashwini T.S
    "1142", // Marshel Steve S Pereira
    "1143", // Fr Arun Prashanth D'Souza SJ
    "1146", // Shilpa Sajeev
    "1150", // sreenivas
    "1151", // Chinappa B G
    "1152", // DOC-PHY
    "1154", // DOC-CHEM
    "1155", // SJUDATA
    "1158", // DOC-MATH
    "1159", // DOC-COMMERCE
    "1161", // DOC-ENG
    "1162", // DOC-COMM
    "1163", // DOC-BDATA
    "1164", // DOC_COMPSC
    "1165", // DOC-ECO
    "1166", // Grace Maria Jochan
    "1167", // DOC-BIOTECH
    "1168", // DOC-BOT
    "1170", // DOC-ENVSCI
    "1171", // DOC-MICROBIOLOGY
    "1172", // DOC-POLSCI
    "1173", // DOC-PSYCH
    "1174", // DOC-PGSW
    "1175", // DOC-UGSW
    "1176", // DOC-STAT
    "1177", // DOC-ZOOLOGY
    "1178", // Prashanth Kumar
    "1179", // Priya S
    "1180", // Dr Preethi Sarah J P
    "1181", // Ranganatha B
    "1182", // Vidhya B
    "1183", // Lakshmi S
    "1184", // Kanishka K
    "1185", // Ebenezer K
    "1186", // ANNIE SYRIEN
    "1187", // TIMOTHY PAUL L
    "1188", // Mr. Jerrin Chandan S
    "1189", // Ms. Prathibha Sara Jacob
    "1190", // Sr. Saly Joseph
    "1192", // Mahesha D K
    "1193", // Chandni Bhambhani
    "1197", // Mr. John Bosco
    "1198", // Mr. Joswin
    "1199", // Ms. Dorothy Deepa
    "1200", // Ms. Ankitha
    "1201", // Ms. Lavanya
    "1202", // Ms. Thara
    "1207", // Shridevi
    "1208", // Hall ticket Grievance cell
    "1209", // Mr. Jeffin Lijo
    "1210", // VISMAYA V
    "1211", // Godfrey Stephen
    "1212", // Pavithra
    "1213", // NISHANTH M J
    "1214", // Revathi Suresh
    "1215", // Shreejita  Biswas
    "1216", // Abirami Govindarajan
    "1217", // Satish Honnanagar
    "1219", // Ancila Urumese
    "1220", // Wicky William Kachhap
    "1221", // RAJANNA.A.H.
    "1222", // Gayathri krishnan
    "1223", // Anisha David
    "1226", // Akhila S Prakash
    "1228", // Muktha Chand P
    "1229", // SABIA MUMTAZ
    "1231", // Prem B G
    "1232", // Arpitha Shruthi L
    "1233", // Mr. Jenil K George
    "1234", // Ms. Arpitha Jain
    "1235", // Debalina Chaudhuri
    "1238", // Mr.Gautam
    "1241", // Alaknanda J Adur
    "1244", // Sanil Cornelio
    "1245", // Mr. Calvin
    "1246", // Anthony Anusha B
    "1248", // Neha Jha
    "1249", // Reghunath P
    "1250", // Ms. Aabharna
    "1253", // Revathi C
    "1255", // IRFAANA FATIMA SHAHED
    "1256", // Dr Daniel Andrew M Gideon
    "1257", // Mr.Ravindran
    "1259", // Anugraha Lalu
    "1260", // Prof Cheriyan Alexander
    "1262", // Nazarius Manoharan
    "1265", // Swathi S Narayan
    "1273", // Dr.Ratnakshi
    "1274", // Guru Datta
    "1275", // Rajul K
    "1276", // Stephen Babu
    "1277", // Shubhashree Joshi
    "1278", // Akshay Kumar AV
    "1279", // Maria Wajid
    "1280", // Varun Rajan V
    "1281", // Beena Ambrose
    "1283", // Arpita I G
    "1288", // Mr  Sunil G N
    "1289", // Mr. Raghuveer
    "1291", // SJUADMIN
    "1296", // Ryan Peter
    "1298", // Sheela Paul
    "1299", // Avita Tellis
    "1301", // Justin Bernard
    "1303", // Yashasvi S
    "1306", // uat
    "1310", // Test
    "1311", // Pruthvi
    "1312", // PUSHPALATHA
    "1313", // SANDEEP
    "1314", // SAINATH
    "1315", // Raghuvir
    "1317", // Mahuya
    "1318", // PRAJEESH
    "1319", // STEPHEN DEEPAK
    "1320", // Praveen Paul
    "1321", // VENUGOPAL
    "1322", // Shwetha
    "1323", // Nalani
    "1324", // Nitin
    "1326", // Narahari
    "1327", // Peter
    "1328", // Subhashini
    "1330", // Kamal
    "1331", // Madhura George
    "1332", // PRITHVI GRACIAN
    "1335", // Praveen K
    "1336", // Vishnuvardhan
    "1356", // Dina Marcel
    "1357", // Prasanna Nirmal Raj D
    "1358", // Ramya Archana
    "1359", // ABRAHAM DANIEL M
    "1361", // Velu Kumar
    "1362", // Sudhir David Diwakar
    "1363", // Sudhakar R
    "1364", // Pinto sagayaraj.j
    "1365", // Balaraju
    "1366", // Japristerry
    "1367", // J deepak clarence
    "1368", // Lakshminarasimha
    "1369", // Nagarathna k n
    "1370", // Anand Mallappa Kattimani
    "1371", // Chandan N
    "1372", // Devaiah AC
    "1373", // Prakash Rathod
    "1374", // Zabeeulla B M
    "1375", // Stalin Alva Edison
    "1376", // Denis Tauro
    "1377", // Mani M
    "1379", // Louis Menezes
    "1380", // Dhananjaya H
    "1381", // Anusha T M
    "1382", // Balasubramanyam. G
    "1383", // S Sagayarani Pramila Kumari
    "1384", // Rajkiran G
    "1385", // Rathnamma
    "1386", // Shankar R
    "1387", // Shree Lakshmi K S
    "1388", // Maha Shriesha V
    "1390", // Santhosh J
    "1393", // Shiny K G
    "1394", // Deepa Nagalavi
    "1395", // Harshita Asthana
    "1396", // Kumar M
    "1397", // Vinitha Dominic
    "1398", // Mohd Yousuf Rather
    "1399", // Keerthana D
    "1400", // Rupa Peter
    "1401", // Lokesha A
    "1402", // Samuel Mores Geddam
    "1403", // Saylie Mekhale
    "1404", // Raj Kiran S
    "1405", // Tejaswini Bastray
    "1407", // Sharmistha Purkayastha
    "1408", // Mohanraj Gunasekaran
    "1409", // Devapriya Sanyal
    "1411", // Anila M M
    "1412", // Jincy A George
    "1413", // Safeya Makhmur
    "1414", // Magesh D
    "1416", // Premajyothi D
    "1417", // Ance Teresa Varghese
    "1418", // Amritha K R
    "1419", // Periyasamy P
    "1420", // Kalavathi M
    "1421", // Mariyamma A
    "1422", // SALOMON  B S
    "1423", // Baby Anusha
    "1424", // Chandran M
    "1425", // Sampath Kumar B
    "1426", // John Peter J
    "1427", // Sunil Kumar BS
    "1428", // Lawrence Rodrigues
    "1429", // Ravi R
    "1430", // VEERASEKARAN K
    "1431", // M Kanika Mary
    "1432", // Hiran Karmakar
    "1433", // Adeppa
    "1434", // Susheela
    "1439", // Mariyappa
    "1442", // Chandrashekhar
    "1445", // KANIKARAJ S
    "1451", // Jesintha D
    "1452", // Abhishek P
    "1453", // Jaswanth Arthimalla
    "1454", // Tadipigari Mahesh Babu
    "1455", // Josphin
    "1456", // Gulbadin Farooq Dar
    "1457", // Sangita Das
    "1458", // Anusmita Chakraborty
    "1459", // Manoj Prabhakar M
    "1460", // Sridevi J
    "1461", // Roshni Sharma
    "1463", // Thomas Jacob
    "1464", // Harini Madhusudan
    "1466", // Reshma Vijayan
    "1467", // Nikita Gloria Pinto
    "1468", // Nagarjun .H
    "1470", // Dulip Kumar
    "1471", // Suman Jadugar
    "1472", // Leena Baptist J
    "1474", // Ritika Misra
    "1475", // Aparupa Bhattacherjee
    "1476", // Sivakumar
    "1477", // Sudha Praveen
    "1478", // Sajan PK
    "1479", // Joel Miranda
    "1480", // TEMP43
    "1481", // Peter Yorke
    "1483", // Sridhar L S
    "1484", // S. Lakshmi Narayanan
    "1485", // T R Dayalan
    "1487", // Divith V Manjunath
    "1489", // Malini
    "1490", // Madhu
    "1491", // Bhanuprakash R
    "1493", // Melwyn Amrithraj
    "1494", // Pradeep P
    "1495", // V. Sarala
    "1496", // Shivananda
    "1497", // Rathna Isaac
    "1498", // Anusuya A Paul
    "1500", // Gayathri Lakshmi N K
    "1501", // Ashish Joseph Hoovaraj . C
    "1504", // DOC-BIOCHEM
    "1505", // DOC-ELE
    "1506", // DOC-FL
    "1507", // DOC-FST
    "1508", // DOC-HIS
    "1509", // DOC-IRPP
    "1510", // DOC-MNG
    "1511", // ABDUL RASHEED KAPPAN
    "1512", // Anushka Meenakshi
    "1513", // Ajna Sultana
    "1514", // Shiva Pathak
    "1515", // Samson Roy
    "1516", // Liya Antony
    "1521", // Shaik Salman
    "1522", // A.M. Sheela
    "1523", // Archana A Malhari
    "1524", // Navya M
    "1525", // Theresa Karra
    "1528", // DOC-HINDI
    "1529", // DOC-GERMAN
    "1530", // Examination Helpdesk
    "1531", // Dalsa V Jose
    "1532", // G Margaret Marina
    "1534", // Ranjini Rao
    "1535", // Rathna Isaac
    "1536", // Harish
    "1537", // Ritika
    "1538", // ERP Admin
    "1539", // Vedavyasa Venkobarao
    "1540", // INT02
    "1541", // INT01
    "1542", // Fr Cyril D Mello S J
    "1544", // Ganesh Achar
    "1546", // Krishnan R
    "1547", // Zulekha
    "1548", // Fouzia
    "1550", // Preetha
    "1552", // Lizzi
    "1553", // Ricky James
    "1555", // Swetavalli Raghavan
    "1556", // Gerald
    "1557", // Satish
    "1558", // Meena
    "1559", // Rachel
    "1560", // Aadithya R Nath
    "1561", // Leyander Lobo
    "1562", // Jayalakshmi K U
    "1563", // Rizwana Khanum
    "1564", // Samrat Das
    "1565", // Mrudhusha Mohanan
    "1566", // Rajini S V
    "1567", // SURESH RAMAVATH
    "1570", // Sonia Patwardhan
    "1571", // Thushara Mariam Thomas
    "1572", // Kodhai B Narayanan
    "1574", // Antony Chacko
    "1575", // K Cyril Menon
    "1577", // Rayirth Bhat
    "1578", // Megha K Jayadas
    "1579", // Mohammed Mueen Pasha M
    "1580", // Anil P
    "1583", // Shalini S
    "1584", // Varghese Mathew
    "1585", // Josephine Devotta
    "1588", // Bharath S Reddy
    "1589", // Yuti Vaghela
    "1590", // DOC-NCC-ARMED
    "1591", // DOC-NCC-AIRWING
    "1592", // DOC-OUTREACH
    "1593", // DOC-Campus Ministry
    "1594", // DOC-NSS
    "1595", // DOC-Student Council
    "1596", // DOC-SPORTS
    "1597", // DOC-PLACEMENTS
    "1598", // DOC-PRO
    "1599", // DOC-REDCROSS
    "1600", // Chander Shekhar
    "1601", // Ryan James Wilson
    "1602", // Sajin Mon S M
    "1603", // Kavitha N
    "1605", // PRADEEP ARYA
    "1606", // B R Manjunath
    "1607", // Maria Delphina
    "1609", // Sreenidhi S
    "1610", // Anu Jose
    "1611", // RAHUL B N
    "1612", // SHUBHRA
    "1613", // Shashank Patel
    "1614", // Shagufta
    "1615", // Dhanesh
    "1633", // AARAN LAWRENCE DLIMA
    "1634", // M GNANARAJ
    "1635", // VALEETA MARINA DSOUZA
    "1636", // SNEHA PAUL
    "1637", // SENTHIL BASKAR
    "1638", // ASHITHA
    "1639", // ARAVIND NANDAKUMAR
    "1640", // SHASHANK S
    "1642", // AMRITH NACHAPPA N
    "1643", // AAQIB DANISH
    "1644", // THULASI KUMAR MARELLA
    "1645", // ARUN MOZHI VARMAN S
    "1646", // RAKSHA A
    "1650", // VARUN WIGHMAL
    "1651", // MADHU KASHYAP J
    "1652", // SRUTHI SURENDRAN P
    "1653", // JANANI NAGARAJAN
    "1654", // SOWMYA K G
    "1655", // YUDHAJIT ROYCHOWDHURY
    "1656", // KEERTHANA C J
    "1657", // Athira K
    "1658", // Geeta D
    "1659", // Rakshitha M.P
    "1661", // MANIVANNAN T
    "1662", // ESTELLE SHEENA D'SOUZA
    "1663", // D VICTORSEELAN
    "1664", // DAVIES VARUGHESE CHACKO
    "1666", // JUNAIDA NALLAKKANDY
    "1667", // LINTO ANTONY
    "1668", // Azhar Shahab
    "1669", // Vishwanath
    "1670", // Vidhyanath
    "1671", // Shivani Kapoor
    "1672", // CV Meenakshi
    "1675", // Seena Menon
    "1676", // Neethu Joseph
    "1677", // Jagadeesha BN
    "1678", // SUDHEENDRA S G
    "1679", // SELVAPERUMAL P
    "1680", // POOJA A
    "1681", // Santo Francis
    "1682", // KARTHICK R V
    "1683", // BHUVANA R
    "1684", // Krishna Prabhakar T
    "1687", // Abhik Maiti
    "1688", // Godwin Emmanuel
    "1689", // Saranya M
    "1690", // Bharath R
    "1691", // Davita Sananda
    "1692", // Jhanavi N
    "1693", // Prema George
    "1694", // Navya Siby
    "1695", // Pranav V S
    "1697", // D JENIFER
    "1698", // Bramhaiah Kommula
    "1699", // Deena Dsouza
    "1700", // SUJOY CHAKRAVARTHI
    "1701", // Muskan Mehta
    "1702", // Kumaraswamy B E
    "1703", // Irene Marie Dove
    "1704", // Sudhindra S
    "1705", // Jagdeesh gokhale
    "1706", // Manoj Vinayaka M
    "1707", // Naveen Kumar R
    "1708", // Manoj P
    "1709", // Saurabh
    "1712", // Babitha
    "1713", // DOC-Counselling
    "1714", // Rebecca D souza
    "1715", // Jayanth R
    "1716", // Natalia
    "1718", // Babu
    "1719", // Edwin Joney
    "1720", // DOC-KANNADA
    "1721", // ArjithDas
    "1722", // Meenakshi
    "1723", // Puneeth G N
    "1724", // PRIYA BALACHANDRA
    "1726", // Anilkumar Sathiraju
    "1727", // Kapil Arambham
    "1728", // Ravikumar K V
    "1729", // Aravind Royce
    "1730", // Sophia Sharon
    "1731", // Theertha Nair A
    "1732", // Janice Caron Correya
    "1734", // Laveena Mariet Veigas
    "1735", // Patricia Beena Stanislaus
    "1736", // A ARCHANA
    "1737", // Stany Steevan
    "1738", // Saumya Ajila
    "1739", // Neha Ann Jishnu
    "1740", // Gadha T. R.
    "1741", // Akash Gugnani
    "1742", // Manu Kumar
    "1744", // Kishore S
    "1745", // Christine Boomstrae Priyadarshini.V
    "1746", // Sylvia Morris
    "1747", // Philarisa Andrea Pde
    "1748", // Ramesh R
    "1749", // Praveen G
    "1750", // Stallin Raj
    "1751", // Joshva J
    "1752", // Lawrence Pereira
    "1753", // Anish S
    "1754", // Joseph Rebello
    "1755", // Praveen L
    "1756", // Sharan Kumar
    "1757", // Stany Antony M A
    "1758", // Allen Lobo
    "1759", // Varsha Valmikinathan
    "1760", // Shashank B Patel
    "1761", // Subhasini M
    "1762", // Shah Daniya
    "1763", // bembala Outreach
    "1764", // Dake Kiran Dashrath
    "1765", // Thanmaya Prakash
    "1766", // Josephine Prapulla
    "1767", // Akshara
    "1768", // DOC-BIOLOGY
    "1769", // Tushar K P
    "1770", // Linways Workflow Support
    "1771", // Nowsin Khatun
    "1772", // SWETHA M
    "1773", // NIVEDITA GHOSH
    "1774", // Gagan
    "1775", // CA  REGISTER
    "1776", // Hari Krishna A
    "1777", // Zainab Fathima Shakir
    "1779", // EXAM IT ADMIN
    "1780", // Shashank
    "1781", // Eshani.R
    "1782", // MANGALAM
    "1784", // MOHITH
    "1785", // Melwyn S. Pinto
    "1786", // Shankar Guddad
    "1787", // Vishanth Anton Menezes
    "1788", // Shubha Das
    "1789", // Srivaideshwari S
    "1790", // Gunjan Gupta
    "1791", // Joyson John Barboza
    "1792", // Sahiti Gavarikar
    "1793", // K M Swathi
    "1794", // Harish H
    "1795", // Austin Richard S
    "1796", // Merlin J
    "1797", // Prakriti Thapa
    "1798", // Muskaan Jain
    "1799", // Shaik Sadiqulla Hussain
    "1800", // Thallapelli Praveen
    "1801", // Disha Ramesh Kalke
    "1802", // Ritu Raveendran
    "1803", // Ramesha H C
    "1804", // Benita Olivera
    "1805", // Srutheesh S
    "1806", // Pooja Kalbalia
    "1807", // Chandraprakash Y
    "1808", // SOMAIAH
    "1809", // Athira Anand
    "1810", // Sarika s
    "1812", // M VINOTHINI
    "1813", // Poulose
    "1814", // Anthony Raj C
    "1815", // Avita Lobo
    "1816", // Rakshitha N
    "1817", // Sourav Bej
    "1818", // Anakha K K
    "1819", // MOHAMMED RAFIQKHAN K
    "1820", // Kiran Sharma
    "1821", // R K Lalnunsangi
    "1822", // M Caroline Maria
    "1823", // Kevin George
    "1824", // Vinod Joseph
    "1825", // Rini Roshan
    "1826", // C N Rahul
    "1827", // M HEMAVATHI
    "1828", // Ishfaq Gulzar
    "1829", // Vinitha A
    "1830", // Meghana. L
    "1831", // Sindhu. J
    "1832", // Sarode Rekha
    "1833", // Anu Kaimal
    "1834", // Sumathi Chari
    "1835", // Meghashree GS
    "1836", // Ashwini D
    "1838", // Lekha M A
    "1839", // Saravanan A
    "1840", // Dakshina U Kanthy
    "1841", // Ishika Jain
    "1842", // Venisha Rodrigues
    "1843", // David A Kalarkop
    "1844", // Deepanshi
    "1846", // Sanathkumar S
    "1847", // SATGURUNATHAN T
    "1848", // RAHUL SEERVI
    "1850", // Joshua Dhawale
    "1851", // Seema Das
    "1852", // Bhardhan
    "1853", // Jismy
    "1854", // PRISCILLA BERNICE P
    "1857", // Varun Ramachandran
    "1858", // Syeda Gazala
    "1859", // Harisankar S
    "1860", // Sivakumar  T
    "1861", // Yugantar Rathore
    "1862", // Yasmin
    "1863", // PUNEETH S.
    "1864", // Marianne Mathew
    "1865", // Asha M Thomas
    "1866", // Challa Rohan Naidu
    "1867", // VENKATESHA
    "1868", // Bala Kiran Kumar SJ
    "1869", // Sujay BM
    "1870", // Gursimran Kaur Mehar
    "1871", // Rohit R
    "1872", // Veithriene Pao
    "1873", // Roonaq un Nisa
    "1874", // Sherly P J
    "1875", // Charan
    "1876", // Kamal vora
    "1877", // Varghese Thomas Panicker
    "1878", // Ocean Minj
    "1879", // SAI PRASAD
    "1880", // SUMATHI
    "1881", // Hari
    "1882", // Ali K S
    "1883", // Sonal
    "1884", // Pawan Kurimindla
    "1888", // testfaculty
    "1890", // Bensen K Alex
    "1891", // Ankush Sharma
    "1892", // Shruthi Kumari
    "1893", // Anubha Gupta
    "1894", // Cletus Rebello
    "1895", // TRINA DUTT
    "1896", // Darshan S Jetty
    "1897", // LOURD RAJ K
    "1898", // SREENIVAS T
    "1899", // Thanmaya Prakash
    "1900", // Chengappa A D
    "1901", // Mohammed Sultan
    "1902", // Nithya David
    "1903", // Ann Thomas
    "1904", // Ronali Jane Dsa
    "1905", // Sonakshi Singh
    "1906", // B L Vinay Kumar
    "1907", // EINSTINA SNEHA
    "1908", // Joyel K. Pious
    "1909", // Ayanti Bera
    "1910", // Noor Dhwan
];

    $total = count($faculty_ids_to_load);
    echo "[" . date('H:i:s') . "] Starting background sync for $total profiles.\n";

    foreach ($faculty_ids_to_load as $index => $id) {
        $current = $index + 1;
        $cache_id = 'faculty_' . trim($id);

        $opts = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Authorization: $API_TOKEN", "Accept: application/json"],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 12 
        ];

        $ch1 = curl_init("https://sjuv4.linways.com/api/v1/staffs/" . urlencode($id));
        curl_setopt_array($ch1, $opts);
        $s_api = json_decode(curl_exec($ch1), true); curl_close($ch1);

        $ch2 = curl_init("https://sjuv4.linways.com/api/v1/exat2/reports/FxNRR5E7W56PzBizk/" . urlencode($id));
        curl_setopt_array($ch2, $opts);
        $r_api = json_decode(curl_exec($ch2), true); curl_close($ch2);

        if ($s_api && $r_api && !isset($s_api['error'])) {
            // REPLACE INTO ensures the profile is updated without being deleted first
            $pdo->prepare("REPLACE INTO api_cache (id, content, created_at, fail_count) VALUES (?, ?, NOW(), 0)")
                ->execute([$cache_id, json_encode(['staff' => $s_api, 'reports' => $r_api])]);
        }
        
        usleep(600000); 
    }
    echo "[" . date('H:i:s') . "] Sync finished.\n";