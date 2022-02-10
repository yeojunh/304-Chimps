# 304-Chimps (Group 43)
304 Chimps :D


## 1. A completed cover page
- Manual handin on Canvas

## 2. A brief (half-page or paragraph) project description answering these questions:
- What is the domain of the application?  Describe it.
- What aspects of the domain are modeled by the database?
    - The domain of the application is a recreation centre. That is, we will focus on the data that is stored about aspects of a recreation centre ranging from membership accounts, programs offered, and building setup. The building setup for this particular recreation centre will include weight rooms, gyms, swimming pools, and skating arenas. There are multiple membership account options, including fitness centre access, gymnasium access, pool access, arena access, drop in, long-term membership with different rates depending on age (toddler, student, adult, elderly), and family deals. 


## 3. Database specifications: (3-5 sentences)
- What benefit does the database provide to the application?
    - The database facilitates data access, addition, deletion, updates, and maintaining of the appliation using entities and relationships. 
    - The database will have hierarchies (ISA hierarchy) and several relationships (weak entity relationships, various cardinalities) to accurately and efficiently represent the types of data and relationships within the recreation centre. 

- What functionality will the database provide?
    - This database allows for easier management of the different components of a recreation center.
    - The database also offers a potential template for other cities to use in their own recreation centers as most facilities share at least some common features.


## 4. Description of the application platform: (2-3 sentences)
- What platform will your project use?
    - This project will be done using the CPSC department's MySql database system, using PHP.
- What is your expected application technology stack?
    - We will use PHP as our programming language to create and manage the SQL database. 
    - For our relational database management, we will use MySQL. 
    - Therefore, the platform we will use is MySQL + PHP. 

- You  can  change/adjust  your  tech  stack  later  as  you  learn  more  about  how  to  get 
started  for  the  project  via  latter  tutorials  in  the  course  regarding  SQL*Plus/Oracle, Java/JDBC, PHP, etc.   The coding is expected to start later on.


## 5. An ER diagram for the database that your application will use.
- Your ER diagram needs to meet the aforementioned requirements, e.g., 7 entity sets, and so on. It is OK to hand-draw it but if it is illegible or messy or confusing, marks will be taken off.  You can use software to draw your 
diagram (e.g., draw.io, GoogleDraw, Microsoft Visio, Gliffy, maybe Word, etc.) The result should be a legible PDF or PNG document.  Note that your ER diagram must use the conventions from the textbook and the lectures (but no crow’s feet notation or notation from other textbooks).
    - ENTITIES: 
        - Staff
            - Lifeguards
            - Manager
            - Front desk 
            - Volunteer
            - Program instructors 
        - Fitness centre (work-out gym)
        - Pool 
        - Membership
            - Fitness centre access
            - Gymnasium access
            - Pool access
            - One-time (drop-in) 
            - Age-dependent (student, adult, senior, toddler)
            - Duration-based (annual, monthly, swipes)
            - Family deals (max 2 adults and dependents)
        - Programs
            - Personal trainer program
            - Weekly intermurals
            - 
        - Arena (rink)
        - Events
            - One-time events
            - Recurring events         
        
    - ISA: 
        - lifeguard, manager, frontdesk, referee ISA => Employee
        - student, adult, senior ISA => Membership
    - Relationships:
        - watches over
        - works in
        - manages
        - uses (equipment)
        - is bundled in (family plan)
        - is part of (program?)
        - volunteers for 

## 6. Other comments, as appropriate, to explain your project.

