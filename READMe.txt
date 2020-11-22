READMe file for church_admin_portal

-----------------------------------------------------------------------------------------------------------------
TO RUN THE WEB APP
-----------------------------------------------------------------------------------------------------------------
To run, must have Xampp installed with PHPMyAdmin. The web app makes use of MySQL on PHPMyAdmin.


-----------------------------------------------------------------------------------------------------------------
DATABASE STRUCTURE
-----------------------------------------------------------------------------------------------------------------

The database structure of this application is based on associating data viewing privileges to particular offices.
A brief description of the different tables is given below:

member_register: 
	-where all members of the church/fellowship are stored. It is the one into which first timers are added.
	-Stores all essential contact data about each person

users:
	-stores the login credentials (password, member id) of all who have accounts on the platform. Pastors, officers,
	 cell leaders etc. can have accounts

offices:
	-stores each of the ministry offices and their respective officer as member ID. 
	-Each office has officeID

user_privileges:
	-maps users to the different offices they have privilege to view data from. For example Blessed will be mapped to
	 PFCC and LMAM office, meaning they can view data from those two offices. 
	-an office can be mapped to multiple people

categories:
	-specifies the different data tables that can be viewed by users. Examples are Tithes, Cell Reports, Member register.

office_privileges:
	-specifies the different categories that each office has under it. So Finance and Treasury office would have
	 Tithes, Partnerships etc. and PFCC would have Cell Reports, Cell leaders etc. under it.

table_names:
	-stores the names of the (relevant) tables

privileges:
	-ignore this table. Yet to be deleted

leaders:
	-has the list of all leaders and their respective offices and roles. (Might change this a bit)

cell_groups:
	-list of all cell groups and their leaders
	-this is the table in which cell leaders are also taken from

cell_reports:
	-stores cell reports according to cell name, date, attendance etc.

church_attendance:
	-used to store attendance for services

all other tables are self explanatory...


----------------------------------------------------------------------------------------------------------------
FUNCTIONALITY OF THE PLATFORM
----------------------------------------------------------------------------------------------------------------
-The group pastor can view all of the group's data
-Anyone else who then creates an account, they are first automatically added into the member_register (if they are
 not there already) and then added to the users table
-By default, new users are not allocated to any office yet and hence have no data viewing privileges. The group 
 pastor has to manually go and assign offices to people


