# Inscription

This is repository hosting the website for pre-booking seats for Ronde de l'Espoir events.
Please note it only supports one single event for the moment, and that event's id is currently hardcoded to 'Gala'

## The concept and the database schema

The system works according to social graphs.

From now on, *a* database entry will be called a *node*.

In the database, each node has the following common fields :
* `id` : 9-digit node ID number
* `fname` : node's first name
* `lname` : node's last name
* `age` : node's age category (`minor` or `minor`)
* `email` : node's email
* `phone` : node's phone number
* `price` : the amount due (seems self-explanatory with the age, but is useful for VIPs)
* `hasPaid` : if the `price` has already been paid
* `eventInfo` : always `Gala`

Generally, nodes are independent, but there can exist links between them.
There are thus 3 types of nodes, defined by the values of 2 database fields :

* Independent nodes :
    * `parentNode` : empty
    * `nChildren` : 0
* Parent nodes : 
    * `parentNode` : empty
    * `nChildren` : the number of nodes which have this node's ID in `parentNode`
* Children nodes :
    * `parentNode` : their parent's ID
    * `nChildren` : 0

These node types are exclusive, meaning that a node cannot be of 2 types at once (sorry Schrödinger...).
So, a parent node cannot have a parent itself, and a child node cannot have children itself.

When a user adds someone on the `/ajouter-des-proches` page, he is changing from an independent node to a parent node

Every time he adds a new person, he is :
* spawning a new child node that will have the user's ID as `parentNode`
* incrementing his `nChildren` by 1

If the user then deletes all his children, he reverts back to independent type.

Please note that node types don't actually exist for the code : the final `/enregistrement` just sets the correct values on the `parentNode` and `nChildren` properties, subsequently setting the node type.

Maybe you should consider adding the type as an actual property to make things clearer.

This system isn't only useful when booking : its main purpose is on the D-Day ; much more on that in [app-www](https://github.com/ronde-de-l-espoir/app-www/README.md).

So, in the end, the SQL schema is the following :

```sql
CREATE TABLE `preinscriptions` (
  `uuid` varchar(36) NOT NULL,
  `fname` varchar(225) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `price` float NOT NULL,
  `hasPaid` tinyint(1) NOT NULL,
  `parentNode` varchar(36) NOT NULL,
  `hasChildren` tinyint(1) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 

COLLATE=latin1_swedish_ci;

ALTER TABLE `preinscriptions`
  ADD PRIMARY KEY (`uuid`);

COMMIT;
```

## Libraries used

All PHP libraries are imported/managed by Composer (PHP's `pip`)

### PDFs

The best PHP library to generate a PDF from HTML is DomPDF.
It's the best of its kind, but definitely not the best tool to work with...

It uses CSS2.0 and not 3.3 (as of 2023), so alignement features such as `flex` and `grid` don't work...
Which makes creating a nice PDF *extremely* complicated. Anyway...

### Emails

Currently using PHPMailer as the library.
It's quick, efficient, so I suggest you keep it like it is.

The SMTP password is saved in the `root/..` directory.

## Cancellation

We haven't had time in 2023 to create the cancellation page, but it sure was necessary, because so many people booked extra tickets by mistake, and wanted to cancel one of them, we had to send them emails asking which one to delete...

So please create the cancellation system ; use the basically the same page as `/perdu`, and replace the view and download buttons by a delete button.
Also, I think you should reuse the `/verif-email` page, because it works well.