(function () {
    let tableNum = 0;
    let table = [];
    let funcType = 0; //value stands for func type
    let tableIndex = -1;

    const select_func = document.getElementById("select-func");
    const select_table = document.getElementById("select-table");
    const div_tableInfo = document.getElementById("tableInfo");
    const div_colName = document.getElementById("colName");
    const div_rowValue = document.getElementById("rowValue");
    const div_tip = document.getElementById("tip");
    const bt_commit = document.getElementById("bt-commit");
    const form = document.getElementById("main-form");
    const table_block = document.getElementById("table");

    //start function
    fresh();

    class Table{
        //a constructor should use "constructor" as a method name
        constructor(name,colNum,colName){
            this.name = name;
            this.colNum = colNum;
            this.colName = colName;
            this.rowValue = [];
            this.optionReference = null;
            for (let i = 0; i < colNum;i++){
                this.rowValue[i] = [];
            }
        }
    }

    function createTable(name,colNum,colName) {
        let newTable = new Table(name,colNum,colName);
        tableNum++;
        table.push(newTable);
        let newOption = document.createElement("option");
        newTable.optionReference = newOption;
        newOption.appendChild(document.createTextNode(newTable.name));
        newOption.setAttribute("value",newTable.name);
        select_table.insertBefore(newOption,select_table.options[0]);
        newOption.selected = true;
        tableIndex = tableNum-1;
        freshTable();
    }
    function fresh() {
        hide(div_rowValue,div_colName,div_tableInfo,div_tip);
        show(bt_commit);
        switch (funcType){
            case 0:
                hide(bt_commit);
                break;
            case 1:
                form.elements["tableName"].value = "";
                form.elements["tableNum"].value = "";
                hide(bt_commit);
                show(div_tableInfo);
                break;
            case 2:
            case 3:
                div_rowValue.innerHTML = "";
                if (tableIndex >= 0){
                    let tempTable = table[tableIndex];
                    for (let i = 0; i < tempTable.colNum; i++){
                        const colInput = document.createElement("input");
                        colInput.setAttribute("type","text");
                        colInput.setAttribute("placeholder",tempTable.colName[tempTable.colNum-1-i]);
                        colInput.setAttribute("name","rowValue"+i);
                        div_rowValue.appendChild(colInput);
                    }
                }
                show(div_rowValue);
                break;
            case 4:
                show(div_tip);
                break;
        }
    }
    function freshTable() {
        table_block.innerHTML = "";
        if (tableIndex > -1){
            let tempTable = table[tableIndex];
            if (tableIndex >= 0){
                let tempTable = table[tableIndex];
                let thead = table_block.createTHead();
                let tbody = table_block.createTBody();
                let tr = thead.insertRow(0);
                let cell;
                for (let i = 0; i < tempTable.colNum; i++){
                    cell = tr.insertCell(0);
                    cell.innerText = tempTable.colName[i];
                }
                for (let i = 0; i < tempTable.rowValue[0].length; i++){
                    tr = tbody.insertRow(i);
                    for (let j = 0; j < tempTable.rowValue.length; j++){
                        cell = tr.insertCell(j);
                        if (tempTable.rowValue[j][i]){
                            cell.innerText = tempTable.rowValue[j][i];
                        }
                    }
                }
            }
        }
    }
    function showColName() {
        div_colName.innerHTML = "";
        if(form.elements["tableName"].value&&form.elements["tableNum"].value){
            let colNum = parseInt(form.elements["tableNum"].value);
            for (let i = 0; i < colNum; i++){
                const colInput = document.createElement("input");
                colInput.setAttribute("type","text");
                colInput.setAttribute("placeholder","Attribute");
                colInput.setAttribute("name","colName"+i);
                div_colName.appendChild(colInput);
            }
            show(div_colName,bt_commit);
        }
        else {
            hide(div_colName,bt_commit);
        }
    }
    function show() {
        for (let i = 0; i <arguments.length; i++){
            if (arguments[i].classList.contains("hidden")){
                arguments[i].classList.remove("hidden");
            }
        }
    }
    function hide() {
        for (let i = 0;i < arguments.length;i++){
            if (!arguments[i].classList.contains("hidden")){
                arguments[i].classList.add("hidden");
            }
        }
    }
    
    //add event listener
    select_func.addEventListener("change",function () {
        for (let i = 0; i < select_func.options.length; i++){
            let option = select_func.options[i];
            if (option.selected){
                funcType = i;
                break;
            }
        }
        fresh();
    });
    select_table.addEventListener("change",function () {
        let option,isChange = false;
        for (let i = 0; i < select_table.options.length; i++){
            option = select_table.options[i];
            if (option.selected){
                break;
            }
        }
        for (let i = 0; i< table.length; i++){
            if (table[i].optionReference === option){
                tableIndex = i;
                isChange = true;
            }
        }
        if (!isChange){
            tableIndex = -1;
        }
        fresh();
        freshTable();
    });
    bt_commit.addEventListener("click",function () {
        if (tableIndex === -1&&funcType > 1){
            return;
        }
        let tempTable = table[tableIndex],isEmpty;//as a flag to check empty input
        switch (funcType){
            case 0:
                break;
            case 1:
                let colNum = parseInt(form.elements["tableNum"].value);
                let tableName = form.elements["tableName"].value;
                let colName = [];
                for (let i = colNum - 1; i >= 0; i--){
                    colName.push(form.elements["colName"+i].value);
                    isEmpty = isEmpty||!form.elements["colName"+i].value;
                }
                if (!isEmpty){
                    createTable(tableName,colNum,colName);
                }
                break;
            case 2:
                isEmpty = true;
                for (let i = 0; i < tempTable.colNum; i++){
                    isEmpty = isEmpty&&(!form.elements["rowValue"+i].value);
                }
                if (!isEmpty){
                    let temp = tempTable.rowValue[0].length;
                    for (let i = 0; i < tempTable.colNum; i++){
                        tempTable.rowValue[i][temp] = form.elements["rowValue"+i].value;
                    }
                    freshTable();
                }
                break;
            case 3:
                let row=0,isMatch,val = [];
                for (let j = 0; j < tempTable.colNum; j++){
                    val[j] = form.elements["rowValue"+j].value;
                }
                while (row < tempTable.rowValue[0].length){
                    isMatch = true;
                    for (let j = 0 ; j < tempTable.colNum; j++){
                        isMatch = isMatch&&(val[j] === tempTable.rowValue[j][row]||!val[j]);
                        if ((j === tempTable.colNum - 1)&&isMatch){
                            for (let i = 0; i < tempTable.colNum; i++){
                                tempTable.rowValue[i].splice(row,1);
                            }
                        }
                    }
                    if (!isMatch){
                        row++;
                    }
                }
                freshTable();
                break;
            case 4:
                select_table.removeChild(tempTable.optionReference);
                select_table.options[0].selected = true;
                table.splice(tableIndex,1);
                tableIndex = (--tableNum)-1;
                freshTable();
                break;
        }
    });
    form.elements["tableNum"].addEventListener("change",showColName);//add function should avoid using "()"
    form.elements["tableName"].addEventListener("change",showColName);
})();