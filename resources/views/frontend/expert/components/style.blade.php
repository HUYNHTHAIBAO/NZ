<style>
    .checkbox-btn {
        display: flex;
        align-items: center;
    }


    .checkbox-group input[type="radio"],
    .checkbox-group input[type="checkbox"] {
        display: none;
    }

    .checkbox-group input[type="radio"].readonly,
    .checkbox-group input[type="checkbox"].readonly_1,
    .checkbox-group input[type="checkbox"].readonly_2,
    .checkbox-group input[type="checkbox"].readonly {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .checkbox-group input[type="radio"].readonly + label,
    .checkbox-group input[type="checkbox"].readonly_1 + label,
    .checkbox-group input[type="checkbox"].readonly_2 + label,
    .checkbox-group input[type="checkbox"].readonly + label {
        background: #bbb7b7;;
    }

    .checkbox-group label {
        display: inline-block;
        padding: 0.5em 1em;
        margin: 0.5em;
        cursor: pointer;
        border: 1px solid #999999;
        border-radius: 5px;
        width: 100%;
        text-align: center;
    }

    .checkbox-group input[type="radio"]:checked + label,
    .checkbox-group input[type="checkbox"]:checked + label {
        background-color: #007bff;
        color: #ffffff;
        border-color: #007bff;
    }
</style>
