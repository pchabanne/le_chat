function focusOnName(){
    document.getElementById('name').focus();
}
 $(document).ready(function(){
    $('.materialboxed').materialbox();
  });
        
document.getElementById('name').onload =  focusOnName()