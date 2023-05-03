<ul class=" list-inline list-unstyled ">
  <li class="list-inline-item col-2  btn btn-primary btn-outline-success bg-white ">
    <?php echo $this->tag->linkTo("product", "Add Products"); ?>
  </li>
  <li class="list-inline-item col-2  btn btn-primary btn-outline-success bg-white ">
    <?php echo $this->tag->linkTo("product/view", "View Products List"); ?>
  </li>
  <li class="list-inline-item col-2  btn btn-primary btn-outline-success bg-white ">
    <?php echo $this->tag->linkTo("order", "Add Order"); ?>
  </li>
  <li class="list-inline-item col-2 btn btn-primary btn-outline-success bg-white ">
    <?php echo $this->tag->linkTo("order/view", "View Order List"); ?>
  </li>
  <li class="list-inline-item col-1  btn btn-primary btn-outline-success bg-white ">
    <?php echo $this->tag->linkTo("setting", "Settings"); ?>
  </li>
  <li class="list-inline-item col-2   ">
  <form action="#">
    <select name="locale" id="" onchange="this.form.submit()" class='form-control border-success'>
    <option value="" >--selected--</option>
      <option value="en_US">English</option>
      <option value="nl_NL">Dutch</option>
    </select>
  </form>
  </li>
</ul>

