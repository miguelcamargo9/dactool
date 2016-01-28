/*!
 FixedColumns 3.0.3
 ©2010-2014 SpryMedia Ltd - datatables.net/license
*/
(function(q,r){var o=function(d){var j=function(a,b){var c=this;if(this instanceof j){"undefined"==typeof b&&(b={});var f=d.fn.dataTable.camelToHungarian;f&&(f(j.defaults,j.defaults,!0),f(j.defaults,b));f=d.fn.dataTable.Api?(new d.fn.dataTable.Api(a)).settings()[0]:a.fnSettings();this.s={dt:f,iTableColumns:f.aoColumns.length,aiOuterWidths:[],aiInnerWidths:[]};this.dom={scroller:null,header:null,body:null,footer:null,grid:{wrapper:null,dt:null,left:{wrapper:null,head:null,body:null,foot:null},right:{wrapper:null,
head:null,body:null,foot:null}},clone:{left:{header:null,body:null,footer:null},right:{header:null,body:null,footer:null}}};f._oFixedColumns=this;f._bInitComplete?this._fnConstruct(b):f.oApi._fnCallbackReg(f,"aoInitComplete",function(){c._fnConstruct(b)},"FixedColumns")}else alert("FixedColumns warning: FixedColumns must be initialised with the 'new' keyword.")};j.prototype={fnUpdate:function(){this._fnDraw(!0)},fnRedrawLayout:function(){this._fnColCalc();this._fnGridLayout();this.fnUpdate()},fnRecalculateHeight:function(a){delete a._DTTC_iHeight;
a.style.height="auto"},fnSetRowHeight:function(a,b){a.style.height=b+"px"},fnGetPosition:function(a){var b=this.s.dt.oInstance;if(d(a).parents(".DTFC_Cloned").length){if("tr"===a.nodeName.toLowerCase())return a=d(a).index(),b.fnGetPosition(d("tr",this.s.dt.nTBody)[a]);var c=d(a).index(),a=d(a.parentNode).index();return[b.fnGetPosition(d("tr",this.s.dt.nTBody)[a]),c,b.oApi._fnVisibleToColumnIndex(this.s.dt,c)]}return b.fnGetPosition(a)},_fnConstruct:function(a){var b=this;if("function"!=typeof this.s.dt.oInstance.fnVersionCheck||
!0!==this.s.dt.oInstance.fnVersionCheck("1.8.0"))alert("FixedColumns "+j.VERSION+" required DataTables 1.8.0 or later. Please upgrade your DataTables installation");else if(""===this.s.dt.oScroll.sX)this.s.dt.oInstance.oApi._fnLog(this.s.dt,1,"FixedColumns is not needed (no x-scrolling in DataTables enabled), so no action will be taken. Use 'FixedHeader' for column fixing when scrolling is not enabled");else{this.s=d.extend(!0,this.s,j.defaults,a);a=this.s.dt.oClasses;this.dom.grid.dt=d(this.s.dt.nTable).parents("div."+
a.sScrollWrapper)[0];this.dom.scroller=d("div."+a.sScrollBody,this.dom.grid.dt)[0];this._fnColCalc();this._fnGridSetup();var c;d(this.dom.scroller).on("mouseover.DTFC touchstart.DTFC",function(){c="main"}).on("scroll.DTFC",function(){if("main"===c&&(0<b.s.iLeftColumns&&(b.dom.grid.left.liner.scrollTop=b.dom.scroller.scrollTop),0<b.s.iRightColumns))b.dom.grid.right.liner.scrollTop=b.dom.scroller.scrollTop});var f="onwheel"in r.createElement("div")?"wheel.DTFC":"mousewheel.DTFC";if(0<b.s.iLeftColumns)d(b.dom.grid.left.liner).on("mouseover.DTFC touchstart.DTFC",
function(){c="left"}).on("scroll.DTFC",function(){"left"===c&&(b.dom.scroller.scrollTop=b.dom.grid.left.liner.scrollTop,0<b.s.iRightColumns&&(b.dom.grid.right.liner.scrollTop=b.dom.grid.left.liner.scrollTop))}).on(f,function(a){b.dom.scroller.scrollLeft-="wheel"===a.type?-a.originalEvent.deltaX:a.originalEvent.wheelDeltaX});if(0<b.s.iRightColumns)d(b.dom.grid.right.liner).on("mouseover.DTFC touchstart.DTFC",function(){c="right"}).on("scroll.DTFC",function(){"right"===c&&(b.dom.scroller.scrollTop=
b.dom.grid.right.liner.scrollTop,0<b.s.iLeftColumns&&(b.dom.grid.left.liner.scrollTop=b.dom.grid.right.liner.scrollTop))}).on(f,function(a){b.dom.scroller.scrollLeft-="wheel"===a.type?-a.originalEvent.deltaX:a.originalEvent.wheelDeltaX});d(q).on("resize.DTFC",function(){b._fnGridLayout.call(b)});var g=!0,e=d(this.s.dt.nTable);e.on("draw.dt.DTFC",function(){b._fnDraw.call(b,g);g=!1}).on("column-sizing.dt.DTFC",function(){b._fnColCalc();b._fnGridLayout(b)}).on("column-visibility.dt.DTFC",function(){b._fnColCalc();
b._fnGridLayout(b);b._fnDraw(!0)}).on("destroy.dt.DTFC",function(){e.off("column-sizing.dt.DTFC destroy.dt.DTFC draw.dt.DTFC");d(b.dom.scroller).off("scroll.DTFC mouseover.DTFC");d(q).off("resize.DTFC");d(b.dom.grid.left.liner).off("scroll.DTFC mouseover.DTFC "+f);d(b.dom.grid.left.wrapper).remove();d(b.dom.grid.right.liner).off("scroll.DTFC mouseover.DTFC "+f);d(b.dom.grid.right.wrapper).remove()});this._fnGridLayout();this.s.dt.oInstance.fnDraw(!1)}},_fnColCalc:function(){var a=this,b=0,c=0;this.s.aiInnerWidths=
[];this.s.aiOuterWidths=[];d.each(this.s.dt.aoColumns,function(f,g){var e=d(g.nTh),i;if(e.filter(":visible").length){var h=e.outerWidth();0===a.s.aiOuterWidths.length&&(i=d(a.s.dt.nTable).css("border-left-width"),h+="string"===typeof i?1:parseInt(i,10));a.s.aiOuterWidths.length===a.s.dt.aoColumns.length-1&&(i=d(a.s.dt.nTable).css("border-right-width"),h+="string"===typeof i?1:parseInt(i,10));a.s.aiOuterWidths.push(h);a.s.aiInnerWidths.push(e.width());f<a.s.iLeftColumns&&(b+=h);a.s.iTableColumns-a.s.iRightColumns<=
f&&(c+=h)}else a.s.aiInnerWidths.push(0),a.s.aiOuterWidths.push(0)});this.s.iLeftWidth=b;this.s.iRightWidth=c},_fnGridSetup:function(){var a=this._fnDTOverflow(),b;this.dom.body=this.s.dt.nTable;this.dom.header=this.s.dt.nTHead.parentNode;this.dom.header.parentNode.parentNode.style.position="relative";var c=d('<div class="DTFC_ScrollWrapper" style="position:relative; clear:both;"><div class="DTFC_LeftWrapper" style="position:absolute; top:0; left:0;"><div class="DTFC_LeftHeadWrapper" style="position:relative; top:0; left:0; overflow:hidden;"></div><div class="DTFC_LeftBodyWrapper" style="position:relative; top:0; left:0; overflow:hidden;"><div class="DTFC_LeftBodyLiner" style="position:relative; top:0; left:0; overflow-y:scroll;"></div></div><div class="DTFC_LeftFootWrapper" style="position:relative; top:0; left:0; overflow:hidden;"></div></div><div class="DTFC_RightWrapper" style="position:absolute; top:0; left:0;"><div class="DTFC_RightHeadWrapper" style="position:relative; top:0; left:0;"><div class="DTFC_RightHeadBlocker DTFC_Blocker" style="position:absolute; top:0; bottom:0;"></div></div><div class="DTFC_RightBodyWrapper" style="position:relative; top:0; left:0; overflow:hidden;"><div class="DTFC_RightBodyLiner" style="position:relative; top:0; left:0; overflow-y:scroll;"></div></div><div class="DTFC_RightFootWrapper" style="position:relative; top:0; left:0;"><div class="DTFC_RightFootBlocker DTFC_Blocker" style="position:absolute; top:0; bottom:0;"></div></div></div></div>')[0],
f=c.childNodes[0],g=c.childNodes[1];this.dom.grid.dt.parentNode.insertBefore(c,this.dom.grid.dt);c.appendChild(this.dom.grid.dt);this.dom.grid.wrapper=c;0<this.s.iLeftColumns&&(this.dom.grid.left.wrapper=f,this.dom.grid.left.head=f.childNodes[0],this.dom.grid.left.body=f.childNodes[1],this.dom.grid.left.liner=d("div.DTFC_LeftBodyLiner",c)[0],c.appendChild(f));0<this.s.iRightColumns&&(this.dom.grid.right.wrapper=g,this.dom.grid.right.head=g.childNodes[0],this.dom.grid.right.body=g.childNodes[1],this.dom.grid.right.liner=
d("div.DTFC_RightBodyLiner",c)[0],b=d("div.DTFC_RightHeadBlocker",c)[0],b.style.width=a.bar+"px",b.style.right=-a.bar+"px",this.dom.grid.right.headBlock=b,b=d("div.DTFC_RightFootBlocker",c)[0],b.style.width=a.bar+"px",b.style.right=-a.bar+"px",this.dom.grid.right.footBlock=b,c.appendChild(g));if(this.s.dt.nTFoot&&(this.dom.footer=this.s.dt.nTFoot.parentNode,0<this.s.iLeftColumns&&(this.dom.grid.left.foot=f.childNodes[2]),0<this.s.iRightColumns))this.dom.grid.right.foot=g.childNodes[2]},_fnGridLayout:function(){var a=
this.dom.grid,b=d(a.wrapper).width(),c=d(this.s.dt.nTable.parentNode).outerHeight(),f=d(this.s.dt.nTable.parentNode.parentNode).outerHeight(),g=this._fnDTOverflow(),e=this.s.iLeftWidth,i=this.s.iRightWidth,h=function(a,b){g.bar?a.style.width=b+g.bar+"px":(a.style.width=b+20+"px",a.style.paddingRight="20px",a.style.boxSizing="border-box")};g.x&&(c-=g.bar);a.wrapper.style.height=f+"px";0<this.s.iLeftColumns&&(a.left.wrapper.style.width=e+"px",a.left.wrapper.style.height="1px",a.left.body.style.height=
c+"px",a.left.foot&&(a.left.foot.style.top=(g.x?g.bar:0)+"px"),h(a.left.liner,e),a.left.liner.style.height=c+"px");0<this.s.iRightColumns&&(b-=i,g.y&&(b-=g.bar),a.right.wrapper.style.width=i+"px",a.right.wrapper.style.left=b+"px",a.right.wrapper.style.height="1px",a.right.body.style.height=c+"px",a.right.foot&&(a.right.foot.style.top=(g.x?g.bar:0)+"px"),h(a.right.liner,i),a.right.liner.style.height=c+"px",a.right.headBlock.style.display=g.y?"block":"none",a.right.footBlock.style.display=g.y?"block":
"none")},_fnDTOverflow:function(){var a=this.s.dt.nTable,b=a.parentNode,c={x:!1,y:!1,bar:this.s.dt.oScroll.iBarWidth};a.offsetWidth>b.clientWidth&&(c.x=!0);a.offsetHeight>b.clientHeight&&(c.y=!0);return c},_fnDraw:function(a){this._fnGridLayout();this._fnCloneLeft(a);this._fnCloneRight(a);null!==this.s.fnDrawCallback&&this.s.fnDrawCallback.call(this,this.dom.clone.left,this.dom.clone.right);d(this).trigger("draw.dtfc",{leftClone:this.dom.clone.left,rightClone:this.dom.clone.right})},_fnCloneRight:function(a){if(!(0>=
this.s.iRightColumns)){var b,c=[];for(b=this.s.iTableColumns-this.s.iRightColumns;b<this.s.iTableColumns;b++)this.s.dt.aoColumns[b].bVisible&&c.push(b);this._fnClone(this.dom.clone.right,this.dom.grid.right,c,a)}},_fnCloneLeft:function(a){if(!(0>=this.s.iLeftColumns)){var b,c=[];for(b=0;b<this.s.iLeftColumns;b++)this.s.dt.aoColumns[b].bVisible&&c.push(b);this._fnClone(this.dom.clone.left,this.dom.grid.left,c,a)}},_fnCopyLayout:function(a,b){for(var c=[],f=[],g=[],e=0,i=a.length;e<i;e++){var h=[];
h.nTr=d(a[e].nTr).clone(!0,!0)[0];for(var k=0,j=this.s.iTableColumns;k<j;k++)if(-1!==d.inArray(k,b)){var l=d.inArray(a[e][k].cell,g);-1===l?(l=d(a[e][k].cell).clone(!0,!0)[0],f.push(l),g.push(a[e][k].cell),h.push({cell:l,unique:a[e][k].unique})):h.push({cell:f[l],unique:a[e][k].unique})}c.push(h)}return c},_fnClone:function(a,b,c,f){var g=this,e,i,h,k,j,l,n,m,p;if(f){null!==a.header&&a.header.parentNode.removeChild(a.header);a.header=d(this.dom.header).clone(!0,!0)[0];a.header.className+=" DTFC_Cloned";
a.header.style.width="100%";b.head.appendChild(a.header);m=this._fnCopyLayout(this.s.dt.aoHeader,c);k=d(">thead",a.header);k.empty();e=0;for(i=m.length;e<i;e++)k[0].appendChild(m[e].nTr);this.s.dt.oApi._fnDrawHead(this.s.dt,m,!0)}else{m=this._fnCopyLayout(this.s.dt.aoHeader,c);p=[];this.s.dt.oApi._fnDetectHeader(p,d(">thead",a.header)[0]);e=0;for(i=m.length;e<i;e++){h=0;for(k=m[e].length;h<k;h++)p[e][h].cell.className=m[e][h].cell.className,d("span.DataTables_sort_icon",p[e][h].cell).each(function(){this.className=
d("span.DataTables_sort_icon",m[e][h].cell)[0].className})}}this._fnEqualiseHeights("thead",this.dom.header,a.header);"auto"==this.s.sHeightMatch&&d(">tbody>tr",g.dom.body).css("height","auto");null!==a.body&&(a.body.parentNode.removeChild(a.body),a.body=null);a.body=d(this.dom.body).clone(!0)[0];a.body.className+=" DTFC_Cloned";a.body.style.paddingBottom=this.s.dt.oScroll.iBarWidth+"px";a.body.style.marginBottom=2*this.s.dt.oScroll.iBarWidth+"px";null!==a.body.getAttribute("id")&&a.body.removeAttribute("id");
d(">thead>tr",a.body).empty();d(">tfoot",a.body).remove();var o=d("tbody",a.body)[0];d(o).empty();if(0<this.s.dt.aiDisplay.length){i=d(">thead>tr",a.body)[0];for(n=0;n<c.length;n++)j=c[n],l=d(this.s.dt.aoColumns[j].nTh).clone(!0)[0],l.innerHTML="",k=l.style,k.paddingTop="0",k.paddingBottom="0",k.borderTopWidth="0",k.borderBottomWidth="0",k.height=0,k.width=g.s.aiInnerWidths[j]+"px",i.appendChild(l);d(">tbody>tr",g.dom.body).each(function(){var a=this.cloneNode(false);a.removeAttribute("id");var b=
d(this).children("td, th");for(n=0;n<c.length;n++){j=c[n];if(b.length>0){l=d(b[j]).clone(true,true)[0];a.appendChild(l)}}o.appendChild(a)})}else d(">tbody>tr",g.dom.body).each(function(){l=this.cloneNode(true);l.className=l.className+" DTFC_NoData";d("td",l).html("");o.appendChild(l)});a.body.style.width="100%";a.body.style.margin="0";a.body.style.padding="0";f&&"undefined"!=typeof this.s.dt.oScroller&&b.liner.appendChild(this.s.dt.oScroller.dom.force.cloneNode(!0));b.liner.appendChild(a.body);this._fnEqualiseHeights("tbody",
g.dom.body,a.body);if(null!==this.s.dt.nTFoot){if(f){null!==a.footer&&a.footer.parentNode.removeChild(a.footer);a.footer=d(this.dom.footer).clone(!0,!0)[0];a.footer.className+=" DTFC_Cloned";a.footer.style.width="100%";b.foot.appendChild(a.footer);m=this._fnCopyLayout(this.s.dt.aoFooter,c);b=d(">tfoot",a.footer);b.empty();e=0;for(i=m.length;e<i;e++)b[0].appendChild(m[e].nTr);this.s.dt.oApi._fnDrawHead(this.s.dt,m,!0)}else{m=this._fnCopyLayout(this.s.dt.aoFooter,c);b=[];this.s.dt.oApi._fnDetectHeader(b,
d(">tfoot",a.footer)[0]);e=0;for(i=m.length;e<i;e++){h=0;for(k=m[e].length;h<k;h++)b[e][h].cell.className=m[e][h].cell.className}}this._fnEqualiseHeights("tfoot",this.dom.footer,a.footer)}b=this.s.dt.oApi._fnGetUniqueThs(this.s.dt,d(">thead",a.header)[0]);d(b).each(function(a){j=c[a];this.style.width=g.s.aiInnerWidths[j]+"px"});null!==g.s.dt.nTFoot&&(b=this.s.dt.oApi._fnGetUniqueThs(this.s.dt,d(">tfoot",a.footer)[0]),d(b).each(function(a){j=c[a];this.style.width=g.s.aiInnerWidths[j]+"px"}))},_fnGetTrNodes:function(a){for(var b=
[],c=0,d=a.childNodes.length;c<d;c++)"TR"==a.childNodes[c].nodeName.toUpperCase()&&b.push(a.childNodes[c]);return b},_fnEqualiseHeights:function(a,b,c){if(!("none"==this.s.sHeightMatch&&"thead"!==a&&"tfoot"!==a)){var f,g,e=b.getElementsByTagName(a)[0],c=c.getElementsByTagName(a)[0],a=d(">"+a+">tr:eq(0)",b).children(":first");a.outerHeight();a.height();for(var e=this._fnGetTrNodes(e),b=this._fnGetTrNodes(c),i=[],c=0,a=b.length;c<a;c++)f=e[c].offsetHeight,g=b[c].offsetHeight,f=g>f?g:f,"semiauto"==this.s.sHeightMatch&&
(e[c]._DTTC_iHeight=f),i.push(f);c=0;for(a=b.length;c<a;c++)b[c].style.height=i[c]+"px",e[c].style.height=i[c]+"px"}}};j.defaults={iLeftColumns:1,iRightColumns:0,fnDrawCallback:null,sHeightMatch:"semiauto"};j.version="3.0.3";d.fn.dataTable.FixedColumns=j;return d.fn.DataTable.FixedColumns=j};"function"===typeof define&&define.amd?define(["jquery","datatables"],o):"object"===typeof exports?o(require("jquery"),require("datatables")):jQuery&&!jQuery.fn.dataTable.FixedColumns&&o(jQuery,jQuery.fn.dataTable)})(window,
document);
