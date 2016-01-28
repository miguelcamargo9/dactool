(function($, undefined) {
    $(function() {
        var info;
        getRingTopologyIfx();
    });
})(jQuery);


function getRingTopologyIfx() {
    $.ajax({
        type: "POST",
        url: "/getTopology",
        async: false,
        dataType: 'json',
        beforeSend: loadStart,
        complete: loadStop,
        success: function(data) {
            info = data;
            draw(info, null);
        },
        error: function() {
            console.log("Error")
        }
    });
}

function loadStart() {
    $('#loading').show();
}

function loadStop() {
    $("#loading").hide();
}

// Called when the Visualization API is loaded.
var options = {
    tooltip: {
        delay: 300,
        fontColor: "black",
        fontSize: 14, // px
        fontFace: "verdana",
        color: {
            border: "#666",
            background: "#FFFFC6"
        }
    }
}

var nodes = null;
var edges = null;
var nodesArray;
var edgesArray;
var network = null;

function draw(devices, group) {
    var textLabel = null;
    var flag = false;
    var flagedge = false;
    var DIR = '/packages/topologia/Images/topologyNetwork/';
    var LENGTH_MAIN = 500,
            LENGTH_SERVER = 150,
            LENGTH_SUB = 50,
            WIDTH_SCALE = 2,
            GREEN = 'green',
            RED = '#C5000B',
            ORANGE = 'orange',
            GRAY = 'gray',
            BLACK = '#2B1B17';
    // Create a data table with nodes.
    nodesArray = [];
    // Create a data table with links.
    edgesArray = [];
    //console.log(devices);

    nodesArray.push({id: 74, label: "COBOGWBPJM320x1\n10.0.120.129", image: DIR + 'router.png', shape: 'image', value: 15});
    nodesArray.push({id: 208, label: "COBOGNOCJM20x3\n200.62.0.130", image: DIR + 'router.png', shape: 'image', value: 15});

    for (var j = 0; j < devices.length; j++) {
        flag = false;
        if (group) {
            for (var h = 0; h < nodesArray.length; h++) {
                if (group != devices[j].NodoA || group != devices[j].NodoB) {
                    flag = true;
                }
                if (nodesArray[h].id == devices[j].SourceNodeID) {
                    flag = true;
                }
            }
            if (!flag) {
                nodesArray.push({id: devices[j].SourceNodeID, label: devices[j].CaptionA + "\n" + devices[j].Ip_AddressA, image: DIR + 'switch.png', shape: 'image', value: 15, group: devices[j].NodoA, grupo: true});
            }
        } else {
            if (nodesArray.length == 0) {
                if (devices[j].propiedadA === '10G' && devices[j].propiedadB === '10G')
                    nodesArray.push({id: devices[j].SourceNodeID, label: devices[j].CaptionA + "\n" + devices[j].Ip_AddressA, image: DIR + 'switch.png', shape: 'image', value: 15, group: devices[j].NodoA});
            } else {
                for (var h = 0; h < nodesArray.length; h++) {
                    if (nodesArray[h].id == devices[j].SourceNodeID) {
                        flag = true;
                    }
                }
                if (!flag) {
                    if (devices[j].propiedadA === '10G' && devices[j].propiedadB === '10G')
                        nodesArray.push({id: devices[j].SourceNodeID, label: devices[j].CaptionA + "\n" + devices[j].Ip_AddressA, image: DIR + 'switch.png', shape: 'image', value: 15, group: devices[j].NodoA});
                }
                flag = false;
                for (var h = 0; h < nodesArray.length; h++) {
                    if (nodesArray[h].id == devices[j].MappedNodeID) {
                        flag = true;
                    }
                }
                if (!flag) {
                    if (devices[j].propiedadA === '10G' && devices[j].propiedadB === '10G')
                        nodesArray.push({id: devices[j].MappedNodeID, label: devices[j].CaptionB + "\n" + devices[j].Ip_AddressB, image: DIR + 'switch.png', shape: 'image', value: 15, group: devices[j].NodoB});
                }

            }
        }
        //nodes.push({ id: (cont + 1), label: devices[j].CaptionB + "\n" + devices[j].Ip_AddressB, group: 'switch', value: 10 });
    }

    for (var k = 0; k < devices.length; k++) {
        flagedge = false;
        var ifaceA = devices[k].InterfaceNameA;
        var ifaceB = devices[k].InterfaceNameB;
        ifaceA = devices[k].InterfaceNameA.replace(/stEthernet|gabitEthernet|nGigabitEthernet/gi, "");
        ifaceB = devices[k].InterfaceNameB.replace(/stEthernet|gabitEthernet|nGigabitEthernet/gi, "");
        textLabel = ifaceA + " - " + ifaceB;
        if (group) {
            for (var l = 0; l < edgesArray.length; l++) {
                if (group != devices[k].NodoA || group != devices[k].NodoB) {
                    flagedge = true;
                }
                if (edgesArray[l].from == devices[k].SourceNodeID && edgesArray[l].to == devices[k].MappedNodeID) {
                    flagedge = true;
                }
            }
            if (flagedge) {
                edgesArray.push({from: devices[k].MappedNodeID, to: devices[k].SourceNodeID, length: LENGTH_MAIN, fontColor: 'BLUE', width: WIDTH_SCALE * 5, label: textLabel});
            } else {
                edgesArray.push({from: devices[k].SourceNodeID, to: devices[k].MappedNodeID, length: LENGTH_MAIN, fontColor: 'BLUE', width: WIDTH_SCALE * 5, label: textLabel});
            }
        } else {
            if (edgesArray.length == 0) {
                if (devices[k].propiedadA === '10G' && devices[k].propiedadB === '10G')
                    edgesArray.push({from: devices[k].SourceNodeID, to: devices[k].MappedNodeID, length: LENGTH_MAIN, fontColor: 'BLUE', width: WIDTH_SCALE * 5, label: textLabel});
            } else {
                for (var l = 0; l < edgesArray.length; l++) {
                    if (edgesArray[l].from == devices[k].SourceNodeID && edgesArray[l].to == devices[k].MappedNodeID) {
                        flagedge = true;
                    }
                }
                if (flagedge) {
                    if (devices[k].propiedadA === '10G' && devices[k].propiedadB === '10G')
                        edgesArray.push({from: devices[k].MappedNodeID, to: devices[k].SourceNodeID, length: LENGTH_MAIN, fontColor: 'BLUE', width: WIDTH_SCALE * 5, label: textLabel});
                } else {
                    if (devices[k].propiedadA === '10G' && devices[k].propiedadB === '10G')
                        edgesArray.push({from: devices[k].SourceNodeID, to: devices[k].MappedNodeID, length: LENGTH_MAIN, fontColor: 'BLUE', width: WIDTH_SCALE * 5, label: textLabel});
                }
            }
        }
        //console.log(textLabel);
    }
    edges = new vis.DataSet(edgesArray);


    // legend
    var mynetwork = document.getElementById('mynetwork');
    var x = -mynetwork.clientWidth / 2 + 50;
    var y = -mynetwork.clientHeight / 2 + 50;
    var step = 70;
    nodesArray.push({id: 1000, x: x, y: y, label: 'Router', group: 'router', value: 15, mass: 0});
    nodesArray.push({id: 1001, x: x, y: y + step, label: 'Switch', group: 'switch', value: 15, mass: 0});
    nodes = new vis.DataSet(nodesArray);

    // create a network
    var container = document.getElementById('mynetwork');
    var data = {
        nodes: nodes,
        edges: edges
    };
    var options = {
        distanceAmplification: 0.2,
        physics: {barnesHut: {enabled: false}, repulsion: {nodeDistance: 150, springLength: 400, springConstant: 0.037, damping: 0.12}},
        stabilize: true, // stabilize positions before displaying
        smoothCurves: {dynamic: false, type: '1'},
        nodes: {
            radiusMin: 16,
            radiusMax: 32,
            fontColor: BLACK,
        },
        edges: {
            color: GRAY
        },
        groups: {
            'switch': {
                image: DIR + 'switch.png',
                shape: 'image'
                        //shape: 'triangle',
                        //color: '#FF9900' // orange
            },
            desktop: {
                //shape: 'dot',
                //color: "#2B7CE9" // blue
            },
            mobile: {
                //shape: 'dot',
                //color: "#5A1E5C" // purple
            },
            server: {
                //shape: 'square',
                //color: "#C5000B" // red
            },
            router: {
                image: DIR + 'router.png',
                shape: 'image'
                        //shape: 'square',
                        //color: "#109618" // green
            }
        }
    };
    network = new vis.Network(container, data, options);

    network.on("doubleClick", function(params) {
        params.event = "[original event]";
        if (params.nodes.length > 0) {
            var group = nodesArray.filter(function(node) {
                return node.id === params.nodes[0]
            });
            if (group[0].grupo) {
                $.ajax({
                    type: "POST",
                    url: "/getDevice",
                    async: false,
                    dataType: 'json',
                    data: {
                        nodeId: params.nodes[0]
                    },
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(data) {
                        window.location = "/verinterfaces/" + data.ID;
                    },
                    error: function() {
                        console.log("Error")
                    }
                });
            } else {
                var group = info.filter(function(node) {
                    return node.SourceNodeID === params.nodes[0]
                });
                draw(info, group[0].NodoA);
            }
        } else {
            console.log("No selecciono nodo")
        }
    });

    //network.freezeSimulation(true);

}



