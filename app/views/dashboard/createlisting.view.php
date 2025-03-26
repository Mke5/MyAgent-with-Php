<?php
    
    $session = new Core\Session;

    if (!$session->user()) {
        redirect('home');
    }

?>

<?php include_once "includes/header.php"?>

<?php include_once "includes/sidebar.php"?>   

    <?php include_once "includes/states.php"?>

    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
                
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h3 class="section-title" style="margin-bottom: 1rem;text-align: center;">Create House Listing</h3>
                </div>

                <div class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card-body">

                        <form class="needs-validation" action="<?= ROOTPATH ?>/listing/createlisting" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?= $session->csrf_token(); ?>">
                            <div class="form-container">
                                <div class="form-group">
                                    <label for="input-select">Type</label>
                                    <select class="form-control selectpicker" name="type" id="input-select">
                                        <option value="" disabled selected>Select House Type</option>
    
                                        <!-- Detached Houses -->
                                        <optgroup label="Detached Houses">
                                            <option value="single_family">Single-Family Home</option>
                                            <option value="bungalow">Bungalow</option>
                                            <option value="cottage">Cottage</option>
                                            <option value="mansion">Mansion</option>
                                            <option value="villa">Villa</option>
                                        </optgroup>

                                        <!-- Semi-Detached & Attached Houses -->
                                        <optgroup label="Semi-Detached & Attached Houses">
                                            <option value="semi_detached">Semi-Detached House</option>
                                            <option value="terraced">Terraced House (Row House)</option>
                                            <option value="townhouse">Townhouse</option>
                                        </optgroup>

                                        <!-- Multi-Unit Residential Buildings -->
                                        <optgroup label="Multi-Unit Residential">
                                            <option value="duplex">Duplex</option>
                                            <option value="triplex">Triplex</option>
                                            <option value="fourplex">Fourplex</option>
                                            <option value="apartment">Apartment (Flat)</option>
                                            <option value="condo">Condominium (Condo)</option>
                                        </optgroup>

                                        <!-- Traditional & Regional Houses -->
                                        <optgroup label="Traditional & Regional Houses">
                                            <option value="hut">Hut</option>
                                            <option value="cabin">Cabin</option>
                                            <option value="longhouse">Longhouse</option>
                                            <option value="yurt">Yurt</option>
                                            <option value="igloo">Igloo</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="input-select">Category</label>
                                    <select class="form-control selectpicker" name="category" id="input-select">
                                        <option value="for_sale">For Sale</option>
                                        <option value="for_sale">For Rent</option>
                                    </select>
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label for="validationServer05">Description</label>
                                <textarea type="text" class="form-control" id="validationServer05" placeholder="Description of the Listing" value="" name="description" required></textarea>
                            </div>

                            <div class="form-container">
                                <div class="form-group">
                                    <label for="inputText1" class="col-form-label">Sittingroom(s)</label>
                                    <input id="inputText1" name="sittingroom" value="" type="number" min="1" class="form-control" placeholder="Available sittingrooms">
                                </div>

                                <div class="form-group">
                                    <label for="inputText4" class="col-form-label">Bedroom(s)</label>
                                    <input id="inputText4" name="bedroom" value="" type="number" min="1" class="form-control" placeholder="Available bedrooms">
                                </div>

                                <div class="form-group">
                                    <label for="inputText2" class="col-form-label">Bathroom(s)</label>
                                    <input id="inputText2" name="bathroom" value="" type="number" min="1" class="form-control" placeholder="Available bathrooms">
                                </div>

                                <div class="form-group">
                                    <label for="inputText3" class="col-form-label">Kitchen(s)</label>
                                    <input id="inputText3" name="kitchen" value="" type="number" min="1" class="form-control" placeholder="Available kitchens">
                                </div>
                            </div>

                            <div class="form-container">
                                <div class="form-group">
                                    <label for="input-select">State</label>
                                    <select class="form-control selectpicker" name="state" id="state">
                                        <option value="">State</option>
                                        <?php foreach ($states as $state => $lgas): ?>
                                            <option value="<?= $state ?>"><?= $state ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="input-select">LGA</label>
                                    <select class="form-control selectpicker" name="lga" id="lga">
                                        <option value="">Select LGA</option>
                                    </select>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const states = <?= json_encode($states) ?>;
                                        const stateSelect = document.getElementById("state");
                                        const lgaSelect = document.getElementById("lga");

                                        stateSelect.addEventListener("change", function () {
                                            const selectedState = this.value;
                                            lgaSelect.innerHTML = '<option value="">Select LGA</option>';
                                            
                                            if (selectedState && states[selectedState]) {
                                                states[selectedState].forEach(lga => {
                                                    const option = document.createElement("option");
                                                    option.value = lga;
                                                    option.textContent = lga;
                                                    lgaSelect.appendChild(option);
                                                });
                                            }
                                        });
                                    });
                                </script>


                                <div class="form-group">
                                    <label for="validationServer">Address</label>
                                    <input type="text" value="" name="address" class="form-control" id="validationServer" placeholder="Address of the Listing" value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputText00" class="col-form-label">Price</label>
                                <input id="inputText00" name="price" value="" type="number" min="1" class="form-control" placeholder="Price of the Listing">
                            </div>

                            <div class="form-group">
                                <label for="inputText0" class="col-form-label">Images of the Listing</label>
                                <input id="inputText0" name="image[]" value="" type="file" multiple class="form-control">
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display: flex;justify-content: center;">
                                <button class="btn btn-dark" type="submit" name="submit">Create Listing</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "includes/footer.php"?>
    </div>

<?php include_once "includes/foot.php"?>