<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manuscript</title>

    <style type="text/css">
        @page  {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #60A7A6;
            color: #FFF;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
        table{
        	font-size: 15px;
        	width: 90%;
        }
    </style>

</head>
<body>
	<br>
	<div class="invoice" style="margin-left: 60px; margin-top: 80px;">
	    <h3 style="text-align: left; margin-bottom: 50px;"><?php echo e($article[0]->title); ?></h3>
	    <?php if(isset($author_info[0]->name)): ?>
	    <h4>Author Detail</h4>
	    <table>
	        <tbody>
	        <tr>
	            <td style="font-weight: bolder;">Name : </td>
	            <td><?php echo e($author_info[0]->name); ?></td>
	        </tr>
	        <tr>
	            <td style="font-weight: bolder;">Bio : </td>
	            <td ><?php echo e($author_bio[0]->bio); ?></td>
	        </tr>
	        <tr>
	            <td style="font-weight: bolder;">Academic : </td>
	            <td><?php echo e($author_bio[0]->academic); ?></td>
	        </tr>
	        <tr>
	            <td style="font-weight: bolder;">Institute : </td>
	            <td><?php echo e($author_bio[0]->institute); ?></td>
	        </tr>
	        </tbody>
	    </table>
	    <?php endif; ?>
	    <h4>Abstract</h4>
	    <table>
	    	<tbody>
	    		<tr>
	    			<td><?php echo $article[0]->abstract; ?></td>
	    		</tr>
	    	</tbody>
	    </table>
	    <h4>Content</h4>
	    <table>
	    	<tbody>
	    		<tr>
	    			<td><?php echo e($article[0]->excerpt); ?></td>
	    		</tr>
	    	</tbody>
	    </table>
	</div>
</body>
</html>