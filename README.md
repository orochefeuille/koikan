# koikan

## A fullstack project using Symfony5 - week 21, last assessment

### Context
As a PHP web developer in an agency, you have been entrusted with the creation of a business application for a client working in the construction industry. 
Until now, the client's project managers have been using notebooks, whiteboards and post-it notes to manage the progress of construction projects and the various deadlines for the various stages of the project. 
The problem with this system, although functional, is that it is expensive, insecure and requires space. 
The client therefore wanted to develop an application that would allow its project managers to manage their projects in a computerised manner. 

### Functional specifications:
To do this, you need to design an application that allows the user to: 
    - Login with his personal account or to register if he does not have an account.
    - See all the projects of this user on a page-Create a new project via a form.
    - See the details of a project, i.e. the project with its tasks when he clicks on it.
    - Create tasks linked to a particular project via a form.
    - Delete projects and tasks as he desires-Modify projects and tasks as he desires.
    - Indicate if a task is completed-Visually distinguish finished tasks from tasks in progress.
    - View projects and tasks classified by deadline-Archive a project.
    - View archived projects-Use the application on sites via a tablet or a smartphone.

The application is also visually enriched to provide the user with the most intuitive experience possible. 
For example:
    - On hovering over a project all other projects except this one get grey. 
    - The user can choose to temporarily hide a project or a task within a project.

Some additional information: 
    - A user logs in with an email and a password-A project is composed of at least a name, a description, a creation date, a deadline and a status.
    - A task is composed of at least a name, a description, a creation date, a deadline and a status.

In addition to your application, your project will be found in a documentation folder : 
    - A UseCase diagram of the application including the functionalities.
    - A database diagram listing the tables, their contents, their relationships and cardinalities.
    - A class diagram listing the entities of your application, their contents and their relationships.
    - The wireframes of the application which specify at least the template and the main page for the mobile, tablet and PC versions.
    - The project is managed using a Kanban Technical. 

### Specifications tool: 
    - Symfony Framework 5.
    - The use of the generate crud command is allowed.
    - Application security managed with the Symfony.
    - Ideally you generate the data using fixtures.
    - JavaScript ES6.

Translated with www.DeepL.com/Translator (free version)