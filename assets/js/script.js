document.addEventListener("DOMContentLoaded", function () {

    console.log("JS Loaded");

    // COMPANY → MODEL
    document.getElementById("company").addEventListener("change", function () {

        let selected = this.options[this.selectedIndex];
        if (!selected.dataset.id) return;

        let company_id = selected.dataset.id;

        fetch("ajax/get_models.php?company_id=" + company_id)
        .then(res => res.text())
        .then(data => {
            document.getElementById("model").innerHTML = data;
            document.getElementById("model-group").style.display = "block";
        });
    });

    // MODEL → YEAR
    document.getElementById("model").addEventListener("change", function () {

        let selected = this.options[this.selectedIndex];
        if (!selected.dataset.id) return;

        fetch("ajax/get_years.php")
        .then(res => res.text())
        .then(data => {
            document.getElementById("year").innerHTML = data;
            document.getElementById("year-group").style.display = "block";
        });
    });

    // YEAR → FUEL
    document.getElementById("year").addEventListener("change", function () {

        let selected = this.options[this.selectedIndex];
        if (!selected.dataset.id) return;

        fetch("ajax/get_fuels.php")
        .then(res => res.text())
        .then(data => {
            document.getElementById("fuel").innerHTML = data;
            document.getElementById("fuel-group").style.display = "block";
        });
    });

    // FUEL → VARIANT
    document.getElementById("fuel").addEventListener("change", function () {

        let fuelSelected = this.options[this.selectedIndex];
        if (!fuelSelected.dataset.id) return;

        let modelSelected = document.getElementById("model").selectedOptions[0];
        let yearSelected = document.getElementById("year").selectedOptions[0];

        if (!modelSelected.dataset.id || !yearSelected.dataset.id) return;

        let model_id = modelSelected.dataset.id;
        let year_id = yearSelected.dataset.id;
        let fuel_id = fuelSelected.dataset.id;

        fetch(`ajax/get_variants.php?model_id=${model_id}&year_id=${year_id}&fuel_id=${fuel_id}`)
        .then(res => res.text())
        .then(data => {
            document.getElementById("variant").innerHTML = data;
            document.getElementById("variant-group").style.display = "block";
        });
    });

    // VARIANT → SHOW TEXT FIELDS
    document.getElementById("variant").addEventListener("change", function () {

        let selected = this.value;
        if (!selected) return;

        document.getElementById("extra-fields").style.display = "block";
    });

});