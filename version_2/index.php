<!-- Author: Pearse Hutson, pah9qd, 14040826
-->

<!DOCTYPE html>
<html>
<head>
    
    <?php
        include_once('header.php');
    ?>
    
    <style id="custom-style">
        
    </style>
    <script>
        $(document).ready(function() {
            
            //Select the correct radio button
            var checkedRadio = "<?php echo (isset($_GET['table-input']) ? $_GET['table-input'] : '') ?>";
            $(".table-radio").each(function() {
                if($(this).val() == checkedRadio) {
                    $(this).prop('checked', true);
                }
                
            });
            
            //Fill .display-results
            $("#search-form").submit(function(e) {
                console.log("submit?");
                $.get("display_table.php", $(this).serialize(), function(data) {
                    $(".display-results").html(data);
                });
                e.preventDefault();
            });
            
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="search-form">
                <form action="#" method="GET" class="form-inline" id="search-form">
                    <div class="radio">
                        <label class="radio-inline">
                            <input type="radio" class="table-radio" id="country-radio" name="table-input" value="country">
                            Country
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="table-radio" id="city-radio" name="table-input" value="city">
                            City
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="table-radio" id="language-radio" name="table-input" value="language">
                            Language
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="search-input">Search</label>
                        <input type="text" class="form-control" id="search-input" name="search-input" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default" id="submit-btn">Search</button>
                </form>
            </div> <!-- Close search-form -->
        </div> <!-- Close row -->
    </div> <!-- Close Container -->
    
    <!-- The following div's are left blank on purpose. Do not fill. -->
    <div class="display-results"></div>
    <div class="update-popup"></div>
    <div class="message-popup"></div>
</body>
</html>
    