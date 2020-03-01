<style>
  #add-link-on-screen {
    position: fixed;
    right: 20px;
    bottom: 20px;
    cursor: pointer;
    width: 50px;
    height: 50px;
    /* background-color: #e74c3c; */
    background-color: #ff2462;
    text-indent: -9999px;
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    border-radius: 60px;
  }

  #add-link-on-screen span:first-child {
    position: absolute;
    background: #ffffff;
    top: 50%;
    left: 50%;
    margin-left: 0px;
    margin-top: -12px;
    height: 50%;
    width: 1px;
  }

  #add-link-on-screen span:last-child {
    position: absolute;
    background: #ffffff;
    top: 50%;
    left: 50%;
    margin-left: -12px;
    margin-top: 0px;
    height: 1px;
    width: 50%;
  }

  #add-link-on-screen:hover {
    background-color: #e74c3c;
    opacity: 1;
    filter: "alpha(opacity=100)";
    -ms-filter: "alpha(opacity=100)";
  }
</style>

<div class="add-lk" id="add-link-on-screen"><span></span><span></span></div>