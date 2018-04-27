<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/25/2018
 * Time: 3:37 PM
 */
include("SQLConnection.php");
include("Food.php");

class FoodDao
{
    /**
     * PDO instance
     * @var PDO
     */
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new SQLConnection())->connect();
    }

    public function connect()
    {
        $pdo = (new SQLConnection())->connect();
        if ($pdo != null) {
            echo 'Connected to the SQLite database successfully!';
        } else
            echo 'Whoops, could not connect to the SQLite database!';
    }

    public function selectByFoodname($foodname)
    {
        $stmt = $this->pdo->prepare("SELECT * from foods where name=:name;");
        if ($stmt == NULL) {
            error_log("stmt is null", 0);
        }
        try {
            $stmt->execute([':name' => $foodname]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($row == NULL) {
                print("Error in selectByUserID, user not found");
                return NULL;
            } else {
                $foodItem = new Food($row['name'], $row['rating'], $row['image'], $row['description'], $row['station'],
                    $row['day'], $row['votes'], $row['current']);
                return $foodItem;
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }
    }
    function selectAll()
    {
        $stmt = $this->pdo->prepare("SELECT * from foods;");
        if ($stmt == NULL) {
            error_log("stmt is null", 0);
        }
        try {
            $stmt->execute();
            $foodItems = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $foodItem = new Food($row['name'], $row['rating'], $row['image'], $row['description'], $row['station'],
                    $row['day'], $row['votes'], $row['current']);
                print_r($foodItem);
                array_push($foodItems, $foodItem);
            }
            return $foodItems;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }
        return Null;
    }

    function insert($foodItem)
    {
        try {
            $sql = 'INSERT INTO foods(name,rating,image,description,station,day,votes,current) 
                              VALUES(:name,:rating,:image,:description,:station,:day,:votes,:current);';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $foodItem->name,
                ':rating' => $foodItem->rating,
                ':image' => $foodItem->image,
                ':description' => $foodItem->description,
                ':station' => $foodItem->station,
                ':day' => $foodItem->day,
                ':votes' => $foodItem->votes,
                ':current' => $foodItem->current,
            ]);
            return true;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }

    function populate()
    {
        $dao = new FoodDao();
        $dao->insert(new Food('Chicken Wrap', 5, 'chickenwrap.jpg', 'crispy chicken wrap', 'Entree', 'Monday', 1, 'true'));
        $dao->insert(new Food('Buffalo Chicken Penne',5,'buffalochickenpenne.jpg','pasta with chicken in buffalo sauce','Vegetarian','Monday',1,'true'));
        $dao->insert(new Food('Burger Mania', 5,'burgermania.jpg','Angus Beef, Turkey, or Garden','International','Monday',1,'true'));
        $dao->insert(new Food('Bean and Cheese Chimichanga',5,'beanandcheesechimichanga.jpg','chimiganga with beans and cheese','Grill','Monday',1,'true'));
        $dao->insert(new Food('Pan Seared Potstickers with Dipping Sauce and Rice',5,'pansearedpotstickerswithdippingsauceandrice.jpg','filled chinese dumplings','Entree','Monday',1,'true'));
        $dao->insert(new Food('Vegetable Mac and Cheese Bar',5,'vegetbalemacandcheesebar.jpg','mac and cheese with vegies','Spitfire','Monday',1,'true'));
        $dao->insert(new Food('Grilled Cheese Bar',5,'grilledcheesebar.jpg','grilled cheese with tomato soup','Vegetarian','Monday',1,'true'));
        $dao->insert(new Food('Bread Boules',5,'breadboules.jpg','Bread boules with beef, chili, or broccoli cheddar','International','Monday',1,'true'));
        $dao->insert(new Food('New England Clam Chowder',5,'newenglandclamchowder.jpg','clam chowder','Grill','Tuesday',1,'true'));
        $dao->insert(new Food('Veggie Tostada Bowls',5,'veggietostadabowls.jpg','tostada bowls with jalapenos,lettuce,guacamole,sour cream, and other toppings','Entree','Tuesday',1,'true'));
        $dao->insert(new Food('Sauteed Grilled Murray Farms Chicken',5,'sauteedgrilledmurrayfarmschicken.jpg','served with cream sauce','Spitfire','Tuesday',1,'true'));
        $dao->insert(new Food('BBQ Beef Briskett',5,'bbqbeefbriskett.jpg','Beef Briskett or Pork Loin with sides','Vegetarian','Tuesday',1,'true'));
        $dao->insert(new Food('Pancakes',5,'pancakes.jpg','pancakes with local maple syrup','International','Tuesday',1,'true'));
        $dao->insert(new Food('Tacos',5,'tacos.jpg','tacos with tomato, cheese, and lettuce','Grill','Tuesday',1,'true'));
        $dao->insert(new Food('Eggplant Parmesan Plate',5,'eggplantparmesanplate.jpg','eggplant parm','Entree','Tuesday',1,'true'));
        $dao->insert(new Food('Chicken Cavatelli',5,'chickencavatelli.jpg','chicken cavatelli with chipotle pesto alfredo sauce','Spitfire','Tuesday',1,'true'));
        $dao->insert(new Food('Philly Steak and Cheese BLT Sub',5,'phillysteakandcheesebltsub.jpg','steak and cheese with bacon, lettuce, tomato sub','Vegetarian','Tuesday',1,'true'));
        $dao->insert(new Food('Steak and Turkey Tip Toss',5,'steakandturkeytiptoss.jpg','steak and turkey tips','International','Tuesday',1,'true'));
        $dao->insert(new Food('Spinach Lasagna Plate',5,'spinachlasagnaplate.jpg','spinach and lasagna','Grill','Tuesday',1,'true'));
        $dao->insert(new Food('General Tso Chicken',5,'generaltsochicken.jpg','general tso chicken with rice and  broccoli','Entree','Wednesday',1,'true'));
        $dao->insert(new Food('Rotisserie Chicken',5,'rotisseriechicken.jpg','rotisserie chicken with sides','Spitfire','Wednesday',1,'true'));
        $dao->insert(new Food('Angus Quesadilla Burger',5,'angusquesadillaburger.jpg','Burger with fries','Vegetarian','Wednesday',1,'true'));
        $dao->insert(new Food('BBQ Pulled Pork or Chicken Sandwhich',5,'bbqpulledporkorchickensandwhich.jpg','bbq pulled pork or chicken sandwhich','International','Wednesday',1,'true'));
        $dao->insert(new Food('Antipasto Salad Plate',5,'antipastosaladplate.jpg','antipasto salad plate','Grill','Wednesday',1,'true'));
        $dao->insert(new Food('Chicken Pad Thai',5,'chickenpadthai.jpg','chicken pad thai','station','Entree',1,'true'));
        $dao->insert(new Food('Carved Roast Turkey Breast Sandwich',5,'carvedroastturkeybreastsandwich.jpg','turkey breast sandwich','Spitfire','Wednesday',1,'true'));
        $dao->insert(new Food('Chicken Fritters',5,'chickenfritters.jpg','chicken fritters with sauces','Vegetarian','Thursday',1,'true'));
        $dao->insert(new Food('Italiano',5,'italiano.jpg','chicken parm or eggplant parm with pasta and sauce','International','Thursday',1,'true'));
        $dao->insert(new Food('Curried Tofu and Rice',5,'curriedtofuandrice.jpg','tofu and rice','Grill','Thursday',1,'true'));
        $dao->insert(new Food('Pastabilities',5,'pastabilities.jpg','pasta with choice of meat and sauce','Entree','Thursday',1,'true'));
        $dao->insert(new Food('Yankee Pot Roast',5,'yankeepotroast.jpg','pot roast with potatoes, green bean casserole baked beans,roasted brussel sprouts','Spitfire','Thursday',1,'true'));
        $dao->insert(new Food('Ultimate Meatball Sandwich',5,'ultimatemeatballsandwich.jpg','meatball sandwich','Vegetarian','Thursday',1,'true'));
        $dao->insert(new Food('Veggie Nacho Bar',5,'veggienachobar.jpg','nachos with choice of veggies','International','Thursday',1,'true'));
        $dao->insert(new Food('Spinach and Roasted Garlic Tortelloni',5,'spinachandroastedgarlictortelloni.jpg','spinach and tortelloni with tomatoes','Grill','Thursday',1,'true'));
        $dao->insert(new Food('Portobello Beef and Jalapeno Jam Sliders',5,'portobellobeefandjalapenosliders.jpg','beef and jalapeno sliders','Entree','Thursday',1,'true'));
        $dao->insert(new Food('Calzonee',5,'calzonee.jpg','steak and cheese, buffalo chicken, or peperoni calzones','Spitfire','Thursday',1,'true'));
        $dao->insert(new Food('Calabrian Polenta',5,'calabrianpolenta.jpg','served with garbanzo beans, onions and peppers','Vegetarian','Thursday',1,'true'));
        $dao->insert(new Food('Teriyaki Beef Stir-fry',5,'teriyakibeefstir-fry.jpg','served with jasmine rice and veggies','International','Friday',1,'true'));
        $dao->insert(new Food('Rotisserie Turkey Dinner',5,'rotisserieturkeydinner.jpg','rotisserie turkey with sides','Grill','Friday',1,'true'));
        $dao->insert(new Food('Fish Tacos',5,'fishtacos.jpg','grilled fish tacos with mango slaw','Entree','Friday',1,'true'));
        $dao->insert(new Food('Steakhouse Salad',5,'steakhousesalad.jpg','salad with steak','Spitfire','Friday',1,'true'));
        $dao->insert(new Food('Zesty Orange Ginger Chicken Stirfry',5,'zestyorangegingerchickenstirfry.jpg','served with jasmine rice','Vegetarian','Friday',1,'true'));
        $dao->insert(new Food('Hot Turkey Sandwhich',5,'hotturkeysandwich.jpg','turkey sandwhich with cheese, potatoes and carrots','International','Friday',1,'true'));
        $dao->insert(new Food('Baked Potato Bar',5,'bakedpotatobar.jpg','baked potato bar with kale and samosa','Grill','Friday',1,'true'));
        $dao->insert(new Food('Fresh Angus BBQ Bacon Cheeseburger',5,'freshangusbbqbaconcheeseburger.jpg','angus burger with bacon and fries','Entree','Friday',1,'true'));
        $dao->insert(new Food('Chicken Breast Florentine',5,'chickenbreastflorentine.jpg','with rice pilaf and mixed vegetables','Spitfire','Friday',1,'true'));
        $dao->insert(new Food('Teriyaki Tofu Lo Mein',5,'teriyakitofulomein.jpg','Tofu lo mein','Vegetarian','Friday',1,'true'));
        $dao->insert(new Food('Japanese Beef Curry',5,'japanesebeefcurry.jpg','served with jasmine rice','International','Friday',1,'true'));
        $dao->insert(new Food('Honey Mustard Chicken Wrap',5,'honeymustardchickenwrap.jpg','chicken wrap with honey mustard','Grill','Friday',1,'true'));
        }
}
#FoodDao::populate();
//$dao=new FoodDao();
//$foods=$dao->selectAll();
