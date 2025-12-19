
*basic settings
[COMPOSER-01] - Create basic namespaces and autoload +
[HTACESS-01] - Create .htaccess to redirect to index +
[DATABASE-01] - Create Database trait for connection + 
[PROJECT-01] - Create Project class for basic setting +
[GLOBALFUNCTIONS-01] - Create Global functions for project +


[REQUEST-01] - Create Request class with setting field and basic validations +
[REDIRECT-01] - Create RedirectTrait for functions for redirect +
[SESSION-01] - Create Session class with all session methods +

[ROUTE-01] - Create Route class for handling all pages +
[ROUTE-02] - Create RouteHelper class for helper functions +
[ROUTE-03] - Create web.php for testing of Route methods +
[ROUTE-04] - Create index.php with Router and use of web.php +

[CONTROLLER-01] - Create parent Controller class +
[CONTROLLER-02] - Create MyController for test +
[CONTROLLER-03] - Create MyController2 for test +

[MODEL-01] - Create parent Model class +
[MODEL-02] - Create MyModel for test +

[VIEW-01] - Create header page with includes +
[VIEW-02] - Create footer page for end of header page +
[VIEW-03] - Create navigation page +
[VIEW-04] - Create welcome page for test +
[VIEW-05] - Create test page for test +

[FEATURE][MIDDLEWARE-01] - Implement middleware feature +
*Create Middleware interface for every middleware class to implement +
*Create logic for calling multiple middlewares +
*Add middleware calls on router +

[FIX][DATABASE-01] - Change database connection to PDO +
[FEATURE][QUERYBUILDER-01] - Create Query Builder class +
*chained function for queries +


[FIX][MODEL-03] - Fixed model logic and added use of QueryBuilder +
*Delete current query functions from model +
*Add functions for query that call QueryBuilder +

[FIX][REQUEST-01] - Added getAll function+

[FEATURE][QUERYBUILDER-01] - Add QueryBuilder
*create QuerySqlBuilder
*create QuerySqlExecutor
*create QueryBuilder for using all these classes

[FEATURE][MODEL-04] - Add all model functions +
*update +
*save +
*find +
*delete +
*query +
**all this functions call QueryBuilder functions

[REFACTOR][QUERYBUILDER-01] - Clean where statement -
[FEATURE][QUERYBUILDER-02] - Add metadata handling +
*add default finding of primary key for getById,delete,update statements +
*add default finding and handling timestamps +

[TEST][DATABASE,MODEL,QUERYBUILDER] - Test all functionality +

[FEATURE][MODEL-04] - Add all model functions +
*update +
*save +
*find +
*delete +
*query +
**all this functions call QueryBuilder functions

[REFACTOR][QUERYBUILDER-01] - Clean where statement -
[FEATURE][QUERYBUILDER-02] - Add metadata handling +
*add default finding of primary key for getById,delete,update statements +
*add default finding and handling timestamps +

[TEST][DATABASE,MODEL,QUERYBUILDER] - Test all functionality +

[REFACTOR][ROUTE-04] - Creating Router and Router helper classes +


[FEATURE][ROUTE-05] - Add logic for custom url's in web.php ++
*In web.php by adding {value} it finds passed value and put's it into url
*Add error handling

[FEATURE][ROUTE-06] - Add validations in Route ++
*Add validations when adding routes in Route
*Check for existing route
*Ensure all required data are created

[FEATURE][ROUTE-07] - Add all http response code needed --

[FEATURE][MODEL-BINDING-01] - Add model binding ++
*creating objects from passed route parametere value
*passing to 

[FEATURE][ERROR-HANDLING-01] - Add error handling ecosystem
*Add ErrorData
*Add ErrorResolver (Taking error data and sending to error view)
*Add error views (Specific views for displaying errors)

[REFACTOR][ROUTE] - Set all classes with namespace in Route

[FIX][ROUTE-08] - Fix nested groups bug

[FIX][QUERY-VALIDATOR-01] - Create all query validations
*Check for allowed columns if timestamps exist

[FEATURE][QUERYBUILDER,MODEL] - Add expansion of model functionality 
*using like
*add >,<, <=, >=
*add functions SUM, COUNT, AVG, MIN, MAX
*add group by functionality
*add join

[FEATURE][MIGRATION-01] - Add logic for migrations
*Migration or Schema class??
*functions for setting database columns and keys
*default values
*constraints
*timestamps and id
*use of QueryBuilder and QueryExecutor??

[FEATURE][MODEL-05] - Create relations logic

[FEATURE][COMMANDS-01] - Create commands for dynamically building code
*using terminal type commands
*commands can create Models,Controllers,Migrations,Requests,Middlewares dynamically with set path,namespace and uses

[FEATURE][REQUEST-02] - Add custom requests

[FEATURE][API-01] - Add features for API calls

[FEATURE][FILE-01] - Add file management
*File uploads
*Directory management

[FIX][REDIRECT-01] - Created global function instead for redirect