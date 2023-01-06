
/*******************************************************************/
/* Get new customized html ui in order to override the default one. */
/*******************************************************************/
function getHTML( json ) {
  let wrap_data = $( "<div class='wrap-data'></div>" );
  let wrap_img = $( "<div class='wrap-photo'></div>" )
                  .append( $( "<div class='background'></div>" )
                  .append( "<a title='" + json.full_name + "' href='" + json.link + "'><img src='" + json.profile_pic + "'></img></a>" ) );
  wrap_data.append( wrap_img )
           .append( "<div title='" + json.full_name + "'>" + json.full_name + "</div>" );
  
  let rank = $("<div></div>");
  rank.append( "<span class='id'>" + json.id + "</span> ");
  rank.append( "<span>" + json.personal_role.html + "</span> " );
  if(json.company_role.html !== null) {
    rank.append( "<span>" + json.company_role.html + "</span>" );
  }
  wrap_data.append(rank);
    
  return wrap_data.get(0).outerHTML;
}

/***********************************************************************************************/
/* Get generation (level) number and object keys in order to embed them in each of tree nodes. */
/***********************************************************************************************/
function getKeys( level, key, parent_key ){
  return { generation: level, id: key, upline_id: parent_key };
}

/***************************************************************************/
/* This function perform conversion of object array into nested node tree. */
/***************************************************************************/
function renderNodes( json_list ){

  let root = {};
  let temp_list = [];
  json_list.sort( ( a, b ) => { return a['upline_id'] - b['upline_id']; } );

  for( let obj of json_list ){    
    let node = {}; 
    node.children = [];
    node.key = obj.id;
    node.parent_key = obj.upline_id;
    node.innerHTML = getHTML( obj ); 
    node.meta = getKeys( obj.generation, obj.id, obj.upline_id );
  
    if( node.parent_key == null ){
      root = node;   
    } else {
      temp_list.push( node ); 
      if( root.key == node.parent_key ){
        root.children.push( node );         
      } 
      
    }

    for( let n of temp_list ){ 
      if( n.key == node.parent_key ){
        n.children.push( node );            
      } 
    }
    
  }
  return root;        
}

/*********************************************************************/
/* This function perform whenever tree chart change number of nodes. */
/*********************************************************************/
function updateDownlines( custom_config, treeNode, htmlNode ){
  let generation = treeNode.meta.generation + 1;
  if( treeNode.children.length == 0 ){
    let button = $("<a class='collapse-switch'><i class='fas fa-caret-down'></i></a>");
    button.click(function() {
      let btn = this;
      $(btn).addClass("disabled");
      $(btn).find("i").removeClass("fa-caret-down").addClass("fa-spinner fa-spin");

      let node_db = custom_config.json_list;
      custom_config.generation = generation;
      custom_config.upline_id = treeNode.meta.id;

      custom_config.afterError = function(e){
        alert( e.responseJSON.message );
        $(btn).removeClass("disabled");
        $(btn).find("i").addClass("fa-caret-down").removeClass("fa-spinner fa-spin");
      };
      getDownlines( custom_config, node_db);
      
    });

    $( htmlNode ).append(button);
  } 
}

/********************************************************************************/
/* Configuration components for tree chart which are needed for initialization. */
/********************************************************************************/
function getConfig( custom_config ){ 
  return {
    chart: {
      container: custom_config.container_id.startsWith( "#" )? custom_config.container_id : "#" + custom_config.container_id,
      animateOnInit: true,
      animateOnInitDelay: 0,
      node: {
        collapsable: true
      },
      connectors: {
        type: "step",
      },
      animation: {
        nodeSpeed: 300,
        nodeAnimation: "easeInBounce",
        connectorsSpeed: 300,
        connectorsAnimation: "easeInOutBounce"
      },
      callback: {
        'onCreateNode': ( treeNode, htmlNode ) => {
          updateDownlines( custom_config, treeNode, htmlNode );
        },
        'onCreateNodeCollapseSwitch': ( treeNode, htmlNode, htmlSwitch ) => {
          $( htmlSwitch ).append("<i class='fas fa-caret-up'></i>");
        },
        'onAfterClickCollapseSwitch': ( nodeSwitch, e ) => {
          let i = $( nodeSwitch ).find("i");
          i.toggleClass( "fa-caret-down fa-caret-up" );
        }     
      }
    },
    nodeStructure: renderNodes( custom_config.json_list )
  }
};

/*********************************************************************************/
/* Using Ajax to request more downline objects (usually in json format) from db. */
/*********************************************************************************/
function getDownlines( custom_config, storage ){
  return $.ajax({
          url: "/ajax/downline/list/" + custom_config.generation + "/" + custom_config.upline_id, 
          success: function( response ){   
            custom_config.json_list = [...storage, ...response.agents];
            new Treant(getConfig( custom_config ));  
          }, 
          error: function(e) {
            custom_config.afterError(e);
            
          }
        });
}

/************************************/
/* Get started building tree chart. */
/************************************/
function init( custom_config ){
  new Treant( getConfig( custom_config ) );
}
