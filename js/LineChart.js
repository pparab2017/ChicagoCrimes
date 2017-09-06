var GLOBAL_ALL_LINES_ID = "_lineChart_allLinesGroup";
var INTIAL_LINE_THICKNESS = "2";
var ON_HOVER_THICKNESS = "4";
var UNIQUE_ID_STRING = "tool_tip_line_Chart_ID";
var OUTER_RECT_COLOR = "#FFF";


var LineChart = function (_data, divID, width, height, _aesthetics, click)
{
    this.data = _data;
    this.CicleClick = click;
    this.ClickEvent = true;
    this.divID = divID;
    this.width = width;
    this.height = height;
    this.canvasID = "canvas_" + divID;
    this.backGroudColor = _aesthetics.BackGroundColor == "" ? "#DDD" : _aesthetics.BackGroundColor;
    this.gridColor = _aesthetics.GridLineColor == "" ? "#AAA" : _aesthetics.GridLineColor;
    this.margin = (_aesthetics.Margin == 0 || _aesthetics.Margin == null) ? 20 : _aesthetics.Margin;
    this.maxDivisions = (_aesthetics.maxDivisions == 0 || _aesthetics.maxDivisions == null) ? this.data[0].y_Data.length / 2 : _aesthetics.maxDivisions;
}

LineChart.prototype.Draw = function () {
    this.canvas = SVG.makeCanvasForLine(this.canvasID, this.width , this.height + 300, this.width, this.height);
    if (typeof this.canvas == "string")
        this.canvas = document.getElementById(this.canvas);



    this.ConstructBasicStructure();

    var divToDraw = document.getElementById(this.divID);
    divToDraw.appendChild(this.canvas);
}

LineChart.prototype.ConstructBasicStructure = function () {
    var OuterRect = SetRectLineChart(0, 0, this.width, this.height + 150, OUTER_RECT_COLOR, "#fff", "1.5", this.divID + "_OUTER_RECT"); // Outer rect
    var InnerRect = SetRectLineChart(this.margin, this.margin, this.width - (2 * this.margin), this.height - (2 * this.margin), this.backGroudColor, this.gridColor, "1", this.divID + "_INNER_RECT"); // inner rect with border

    var OuterHoverBinder = OuterEvtBinder(this);
    OuterRect.addEventListener("mousemove", OuterHoverBinder, false);
    InnerRect.addEventListener("mousemove", OuterHoverBinder, false);
    this.canvas.appendChild(OuterRect);
    this.canvas.appendChild(InnerRect);


    this.Max = GetMax(this.data);
    this.chartMax = this.Max._max;
    this.objCount = this.Max._count;

    this.numberOfDevision = this.data[0].y_Data.length / 2 > this.maxDivisions ? this.maxDivisions : this.data[0].y_Data.length / 2; // devide by 2 so that we get less range 
    if (this.chartMax > 1) { // check if greater then 1, not required for decimal values
        while (!(this.chartMax % this.numberOfDevision == 0 && (this.chartMax % 5 == 0 || this.chartMax % 2 == 0 || this.chartMax % 3 == 0))) {
            this.chartMax++;
        }
    }

   

    this.scale = (this.height - (2 * this.margin)) / this.chartMax;
    this.vSpace = (this.width - (2 * this.margin)) / (this.data[0].y_Data.length - 1);
    this.hSpace = ((this.height - (2 * this.margin)) / this.numberOfDevision);
    this.hGap = this.hSpace / this.scale;

    for (var i = 0; i <= this.numberOfDevision ; i++) {

        this.canvas.appendChild(
            SetLineChartLine(this.margin,
                    (((this.numberOfDevision - i) * this.hSpace) + this.margin),
                    (this.width - this.margin),
                    (((this.numberOfDevision - i) * this.hSpace) + this.margin),
                    this.gridColor,
                    this.gridColor,
                    "0.4",
                    "4, 2",
                    this.divID + "_GRID_LINE_" + i
                    ));


        this.text = parseFloat(this.hGap * i);
        if (isFloat(this.hGap)) { // float values max round it to 2 decimals 
            this.text = parseFloat(this.hGap * i).toFixed(2);
        }

        this.canvas.appendChild(SetLableLineChart(
                                this.margin - 40,
                                ((this.numberOfDevision - i) * this.hSpace) + this.margin + 5,
                                "sans-serif",
                                "12",
                                "black",
                                "0.15",
                                this.text
                                ));
    }
    this.EachGroupLine();
}



LineChart.prototype.EachGroupLine = function () {

    var completeGroup = document.createElementNS(SVG.ns, "g");
    completeGroup.setAttribute("id", GLOBAL_ALL_LINES_ID + this.divID);

    for (_each in this.data) {

        var _startSpace = this.margin*3;
        var g = document.createElementNS(SVG.ns, "g");
        g.setAttribute("id", this.divID + this.data[_each].Name);

        for (var i = 0; i < this.data[_each].y_Data.length; i++) {

            var pointX = this.margin + (this.vSpace * i);
            var pointX2 = this.margin + (this.vSpace * (i + 1));
            var pointY = (this.margin + (this.height - (2 * this.margin))) - (this.data[_each].y_Data[i] * this.scale);
            var pointY2 = (this.margin + (this.height - (2 * this.margin))) - (this.data[_each].y_Data[i + 1] * this.scale);

            if (_each == 0) {
                var line = SetLineChartLine((i * this.vSpace) + this.margin,
                                    this.margin,
                                    (i * this.vSpace) + this.margin,
                                    this.height - (this.margin),
                                    this.gridColor,
                                    this.gridColor,
                                    "0.4",
                                    "4, 2",
                                    this.divID + "_SINGLE_LINE_" + i
                                    );

                if (i != 0)
                    {
                    this.canvas.appendChild(line);
                }

                var ShowBothRect;

                if (i == this.data[_each].y_Data.length - 1) {
                    
                    ShowBothRect=      SetRectLineChart(
                         (i * this.vSpace) + this.margin - this.vSpace / 2,
                         this.margin,
                         this.vSpace /2,
                         parseInt(this.height - 2 * this.margin),
                        this.gridColor,
                         this.gridColor,
                        "1.5", this.divID + "_EACHHOVERRECT_"+ i)
                       
                }
                else {
                    ShowBothRect =
                        SetRectLineChart(
                        (i == 0) ? (i * this.vSpace) + this.margin : (i * this.vSpace) + this.margin - this.vSpace / 2,
                        this.margin,
                        (i == 0) ? this.vSpace / 2 : this.vSpace,
                        parseInt(this.height - 2 * this.margin),
                        this.gridColor,
                        this.gridColor,
                        "1.5", this.divID + "_EACHHOVERRECT_" + i)
                        
                }
                ShowBothRect.setAttribute("opacity", "0.1");
                var ShowBothRectHover = BothHoverEventHoverBinder(this, _each, i)
                ShowBothRect.addEventListener("mouseover", ShowBothRectHover, false);

                var OnBothRectMouseOut = OuterEvtBinder(this);
                ShowBothRect.addEventListener("mouseout", OnBothRectMouseOut, false);

                this.canvas.appendChild(ShowBothRect);

            }

            if (i != this.data[_each].y_Data.length - 1) {
                var eachLine = SetLine(pointX, pointY,
                    pointX2, pointY2,
                    this.data[_each].Color,
                    this.data[_each].Color, "2", "");
            }

            var lineChartHoverBinder = lineChartEventHoverBinder(this, _each);
            eachLine.addEventListener("mousemove", lineChartHoverBinder, false);

            if (_each == 0) {
                this.canvas.appendChild(SetLableLineChartVertical(
                    pointX - 0,
                    this.height - 50,
                    "sans-serif",
                    "10",
                    "black",
                    ".15",
                    this.data[_each].x_Data[i]
                    ));
            }

            var circle = SetLineChartCircle(this.margin + this.vSpace * i
                                            , pointY
                                            , 6
                                            , "white"
                                            , "1"
                                            , this.data[_each].Color
                                            , this.divID + "_EACH_CIRCLE_" + i
                                            );

            var circleHoverBinder = circleHoverEvtBinder(this, _each, i);
            circle.addEventListener("mousemove", circleHoverBinder, false);

            var OnMouseOut = OuterEvtBinder(this);
            circle.addEventListener("mouseout", OnMouseOut, false);

            if (this.ClickEvent)
            {
                var circlClickBinder = circleClickEvtBinder(this, _each, i);
                circle.addEventListener("click", circlClickBinder, false);
                ShowBothRect.addEventListener("click", circlClickBinder, false);
            }
           



            g.appendChild(eachLine);
            g.appendChild(circle);
          
        }
        

        completeGroup.appendChild(g);
        var cirRadius = 6;
        var clickCir = SetLineChartCircle((_startSpace * _each) + _startSpace 
                                        , (_startSpace / 5) - cirRadius/2
                                        , cirRadius
                                        , "white"
                                        , "1"
                                        , this.data[_each].Color
                                        , this.divID + this.data[_each].Name + "_CLICK"
                                        );
        this.data[_each].toInvoce = this.divID + this.data[_each].Name;
        var toolTableClick = toolTableEvtBinder(this, _each)
        clickCir.addEventListener("click", toolTableClick, false);
        this.canvas.appendChild(SetLableLineChart(
                    (_startSpace * _each) + _startSpace + 10,
                     _startSpace / 5,
                    "sans-serif",
                    "12",
                    "black",
                    ".15",
                    this.data[_each].Name
                    ));
        this.canvas.appendChild(clickCir);

    }

    this.canvas.appendChild(completeGroup);

}


/*--==Animation Functions==--*/
function LineHover(e, obj, i) {

    var completeGroup = document.getElementById(GLOBAL_ALL_LINES_ID + obj.divID);
    

    var allLines = completeGroup.getElementsByTagName("line");
    var allCircles = completeGroup.getElementsByTagName("circle");

    for (var j = 0; j < allLines.length; j++) {
        allLines[j].setAttribute("stroke-width", INTIAL_LINE_THICKNESS);
    }
    for (var j = 0; j < allCircles.length; j++) {
        allCircles[j].setAttribute("stroke-width", INTIAL_LINE_THICKNESS);
    }

    var g = document.getElementById(obj.divID + obj.data[i].Name);
   // g.setAttribute("visibility", "hidden");

    var lines = g.getElementsByTagName("line");
    var Circles = g.getElementsByTagName("circle");

    for (var s = 0; s < lines.length; s++) {
        lines[s].setAttribute("stroke-width", ON_HOVER_THICKNESS);
    }
    for (var s = 0; s < Circles.length; s++) {
        Circles[s].setAttribute("stroke-width", ON_HOVER_THICKNESS);
    }

    var tooltipDivID = UNIQUE_ID_STRING + obj.divID;
    var exsists = document.getElementById(tooltipDivID);
    if (exsists == null) {
        var div = ToolTip.make(tooltipDivID);
        //document.body.appendChild(div);
    }
    //var tooltipdiv = document.getElementById(tooltipDivID);
    //tooltipdiv.innerHTML = obj.data[i].Name;
    //tooltipdiv.setAttribute('style',
     //   'top:' + e.pageY + 'px;' +
     //   'left:' + e.pageX + 'px;' +
     //   'border: 2px solid ' + obj.data[i].Color + ';' +
     //   'position: absolute;');




}



function BasicRects(e, obj) {
    var tooltipDivID = UNIQUE_ID_STRING + obj.divID;
    var elem = document.getElementById(tooltipDivID);
    if(elem != null)
        elem.parentNode.removeChild(elem);


    for (var i = 0; i < obj.data[0].y_Data.length; i++) {
        var rect = document.getElementById(obj.divID + "_EACHHOVERRECT_" + i);
        rect.setAttribute("opacity", "0.1");

    }

}

function OuterEvtBinder(obj)
{
  
    return function (e) { BasicRects(e, obj) };
    
}


function CircleHover(e, obj, currentGroup, pointValue) {


    var tooltipDivID = UNIQUE_ID_STRING + obj.divID;

    var exists = document.getElementById(tooltipDivID);
    if (exists == null) {
        var div = ToolTip.make(tooltipDivID);
        document.body.appendChild(div);
    }
    var tooltipdiv = document.getElementById(tooltipDivID);


    tooltipdiv.innerHTML = obj.data[currentGroup].Name + "<hr/>"
        + obj.data[currentGroup].x_Data[pointValue] + " : " +
        +obj.data[currentGroup].y_Data[pointValue];
        tooltipdiv.setAttribute('style',
        'top:' + (parseInt(e.pageY) + 10)  + 'px;' +
        'left:' + (parseInt(e.pageX) + 10)  + 'px;' +
        'border: 2px solid ' + obj.data[currentGroup].Color + ';' +
        'position: absolute;');
}

function circleHoverEvtBinder(obj, currentGroup, poinValue) {
    return function (e) { CircleHover(e, obj, currentGroup, poinValue); }
}

function toolTableClick(e, obj, currentGroup) {
    var g = document.getElementById(obj.data[currentGroup].toInvoce);
    var v = g.getAttribute("visibility");
    if (v == null || v == "visible") {
        g.setAttribute("visibility", "hidden");
    }
    if (v == "hidden") {
        g.setAttribute("visibility", "visible");
    }

}

function toolTableEvtBinder(obj, currentGroup) {
    return function (e) {
        toolTableClick(e, obj, currentGroup);
       
    }
}

function circleClickEvtBinder(obj, currentGroup, poinValue) {
    return function (e) {
        obj.CicleClick(e, obj, currentGroup, poinValue);
       // CircleClick(e, obj, currentGroup, poinValue);
    }
}

function BothHoverEventHover(e, obj, currentGroup, pointValue) {
    //this.divID + "_EACHHOVERRECT_" + i

    for (var i = 0; i < obj.data[currentGroup].y_Data.length; i++) {
        var rect = document.getElementById(obj.divID + "_EACHHOVERRECT_" + i);
        rect.setAttribute("opacity", "0.1");

    }

    var rect = document.getElementById(obj.divID + "_EACHHOVERRECT_" + pointValue);
    rect.setAttribute("opacity", "0.5");



    var tooltipDivID = UNIQUE_ID_STRING + obj.divID;

    var exists = document.getElementById(tooltipDivID);
    if (exists == null) {
        var div = ToolTip.make(tooltipDivID);
        document.body.appendChild(div);
    }
    var tooltipdiv = document.getElementById(tooltipDivID);

    var completeText =  obj.data[currentGroup].x_Data[pointValue] + " : " ;
    for (_each in obj.data) {
        completeText = completeText + 
          obj.data[_each].y_Data[pointValue] + "-";
    }
    var replacement = ' = ';
    completeText = completeText.replace(/-([^-]*)$/,replacement+'$1'); 
    completeText = completeText + (obj.data[0].y_Data[pointValue]  - obj.data[1].y_Data[pointValue]) ;



    tooltipdiv.innerHTML = completeText;
    tooltipdiv.setAttribute('style',
        'top:' + (parseInt(e.pageY) + 10) + 'px;' +
        'left:' + (parseInt(e.pageX) + 10) + 'px;' +
        'border: 2px solid ' + obj.gridColor + ';' +
        'position: absolute;');


}

function BothHoverEventHoverBinder(obj, currentGroup, pointValue) {
    return function (e) { BothHoverEventHover(e, obj, currentGroup, pointValue) };
}

function lineChartEventHoverBinder(obj, i) {
    return function (e) { LineHover(e, obj, i) };

}

/*--==Animation Functions - ENDS==--*/

/*--==Helper Functions==--*/
function GetMax(_data) {

    var max = 0.0;
    var maxSelected = false;
    var _objects = 0;
    for (_eachLine in _data) {
        _objects ++;
        if (_data.hasOwnProperty(_eachLine)) {
            for (var _each = 0; _each < _data[_eachLine].y_Data.length; _each++) {
                if (max < _data[_eachLine].y_Data[_each])
                    max = _data[_eachLine].y_Data[_each];
            }

        }
    }
   
    return {_max:BasicRound(max),_count:_objects};
}

function BasicRound(number) {

    if (number < 1.0) {
        number = number ;
        number = (number.toFixed(2));
    }
    else if (number < 10) {
        number = 0 + Math.ceil(number / 1) * 1;
        
    }
    else {
        var _extra = 0;
        if (number % 10 == 0) { _extra = 0; }
        number = _extra + Math.ceil(number / 10) * 10;
    }
    return number;
}

function isFloat(n) {
    return n === Number(n) && n % 1 !== 0
}
/*--==Helper Functions - ENDS==--*/














