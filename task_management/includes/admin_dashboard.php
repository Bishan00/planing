<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Styling for the Dashboard elements */
        .element-content {
    background-color: #F28018;
    padding: 0;
    text-align: center;
    box-shadow: 2px 2px 4px rgba(0, 0, 10, 100);
    
    /* Make the element fill the full page */
    position: right;
    top: 0;
    left: 5px;
    width: 100%;
    height: 100%;
}



        .element-box {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 60px;
            margin: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .element-header {
            color: #000000;
            font-size: 24px;
            font-weight: bold;
        }

        .element-box a {
            text-decoration: none;
            color: #F28018;
        }

        /* Styling for the specific elements with id="myDIV" */
        #myDIV {
            color: #000000;
            font-weight: bold;
            font-size: 20px;
            margin-top: 10px;
        }
    </style>
    <title>Your Dashboard</title>
</head>
<body>
    <div class="element-content">
        <h6 class="element-header">Dashboard</h6>
        <div class="row">
            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="work_order_show.php">
                    <div id="myDIV">Work Order</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="stock.php">
                    <div id="myDIV">Stocks</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="planbuttoon.php">
                    <div id="myDIV">Plan</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="bom_all.php">
                    <div id="myDIV">BOM</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="press_list.php">
                    <div id="myDIV">Dispatch Work Order</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="get_reject.php">
                    <div id="myDIV">Daily Reject List</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="match2.php">
                    <div id="myDIV">Mould Changing List</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="order_quantity.php">
                    <div id="myDIV">Orders Quantity</div>
                </a>
            </div>

            <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="daily_production.php">
                    <div id="myDIV">Daily Production</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
