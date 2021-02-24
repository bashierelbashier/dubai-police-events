        <?php
        if ($_SESSION['PRIVILEGE'] == 1)
            echo '<li><a href="../index.php"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="owners.php"><i class="fa fa-male"></i> أصحاب الأراضي  </a></li>
        <li><a href="transactions.php"><i class="fa fa-exchange"></i> المعاملات </a></li>
        <li><a href="reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>
        <li><a href="control_panel.php"><i class="fa fa-gears"></i> لوحة التحكم </a></li>
        <li><a href="base_data.php"><i class="fa fa-database"></i> البيانات المرجعية </a></li>';
        else if ($_SESSION['PRIVILEGE'] == 2)
            echo '<li><a href="../index.php"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="owners.php"><i class="fa fa-male"></i> أصحاب الأراضي  </a></li>
        <li><a href="transactions.php"><i class="fa fa-exchange"></i> المعاملات </a></li>
        <li><a href="reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>
        <li><a href="base_data.php"><i class="fa fa-database"></i> البيانات المرجعية </a></li>';
        else if ($_SESSION['PRIVILEGE'] == 3)
            echo '<li><a href="../index.php"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="transactions.php"><i class="fa fa-exchange"></i> المعاملات </a></li>
        <li><a href="reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>';
        else if ($_SESSION['PRIVILEGE'] == 4)
            echo '<li><a href="../index.php"><i class="fa fa-home"></i> الرئيسية </a></li>
        <li><a href="reports.php"><i class="fa fa-file-pdf-o"></i> التقارير </a></li>';
        else if ($_SESSION['PRIVILEGE'] == 5)
            echo '<li><a href="../index.php"><i class="fa fa-home"></i> الرئيسية </a></li>';
        ?>
