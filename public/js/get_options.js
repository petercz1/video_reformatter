console.log('get_options loaded');

function get_options() {
  options = {
    url: 'app/public.php',
    type: 'GET',
    data: {
      'command': 'getOptions'
    },
    success: build_options,
    error: display_error
  };
  $.ajax(options);
}

function build_options(data, status, xhr) {
  data = JSON.parse(data);
  console.log(data);
  // TODO do an order_by here first?
  $.each(data, build_option);
}

function build_options(option) {
  switch (option['type']) {
    case 'string':
      build_string(option);
      break;
    case 'int':
      build_int(option);
      break;
    case 'radio':
      build_radio(option);
      break;
    case 'checkbox':
      build_checkbox(option);
      break;
    case 'dropdown':
      build_dropdown(option);
      break;
  }
}

function build_string(option) {

}

function build_int(option) {

}

function build_radio(option) {

}

function build_checkbox(option) {

}

function build_dropdown(option) {

}

function create_div(option) {
  div = document.createElement("div");
  div.setAttribute("class", "form-group");
  txt = option['name'];
  txt = document.createTextNode(txt);
  // create label and append text
  label = document.createElement("label");
  label.setAttribute("for", option['name']);
  label.appendChild(txt);
  div.appendChild(label);
  return div;
}

// function build_options(data_item, data_value) {
//   console.log(data_item + ': ' + data_value['name']);

//   // create BootStrap form-group
//   div = document.createElement("div");
//   div.setAttribute("class", "form-group");

//   // create text label out of key by removing underscores
//   txt = data_item.toString().replace(/_/g, ' ');
//   txt = document.createTextNode(txt);

//   // create label and append text
//   label = document.createElement("label");
//   label.setAttribute("for", data_item);
//   label.appendChild(txt);

//   option = document.createElement('input');
//   if (typeof data_value == "boolean") {
//     option.setAttribute("class", "form-check form-check-inline");
//     option.setAttribute("type", "radio");
//     option.setAttribute("name", data_item);
//     option.setAttribute("id", data_item + "_true");
//     append_setting(label, option);

//     option.setAttribute("class", "form-check form-check-inline");
//     option.setAttribute("type", "radio");
//     option.setAttribute("name", data_item);
//     option.setAttribute("id", data_item + "_false");
//     append_setting(label, option);

//   } else {
//     option.setAttribute("type", "text");
//     option.setAttribute("class", "form-control");
//     option.setAttribute("id", data_item);
//     option.setAttribute("value", data_value);
//     append_setting(label, option);
//   }
// }

function append_setting(label, option) {
  div.appendChild(label);
  div.appendChild(option);
  document.getElementById("app_options").appendChild(div);
}