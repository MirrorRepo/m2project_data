function submitFormInPopUp(data,dir) 
      {

        const months = ["January", "February", "March", "April", "May", "June",
                           "July", "August", "September", "October", "November", "December"];

        var file = data.split("/");
        var year = [], i,j;
                
        PopUpWindow = window.open('','','toolbar=no,scrollbars=yes,resizable=yes,top=200,left=400,width=400,height=400');      
      
        for(i=0,j=0;i<file.length;i++)
        {
          var f1 = file[i].split("export");
          var f2 = f1[1].split(".");
          var f3 = f2[0].split("to");
          var f4 = f3[0].split("-");
          var f5 = parseInt(f4[1]);
          var f6 = months[f5-1];

          if(year[j-1]!= f4[0])
          {
            year[j] = f4[0];
            j=j+1;
          }
        }

        PopUpWindow.document.write("<div align=center>");
        PopUpWindow.document.write("<div align=center><h3>choose a file & Download </h3>");
        PopUpWindow.document.write("<div><h4>Select a Year</h4><select id= 'mySelect' onchange='myFunction()' >");
        PopUpWindow.document.write("<option value ='#' >select a year</option>");
        
        for(y=0;y<year.length;y++)
        {
           PopUpWindow.document.write("<option value='"+year[y]+"'>"+year[y]+"</option>");
        }

        PopUpWindow.document.write("</select></div>");
        PopUpWindow.document.write('<script type="text/javascript">function myFunction(){ var x = document.getElementById("mySelect").value;var lst = document.getElementsByClassName("row");for(var i = 0; i < lst.length; ++i) { lst[i].style.display ="none";} var fst = document.getElementsByClassName(x);for(var i = 0; i < fst.length; ++i) { fst[i].style.display ="table-row";}}');
        PopUpWindow.document.write("</script><br><table border='5'>");
        PopUpWindow.document.write("<tr><th>Month</th><th>Download Link</th></tr>");

        for(i=0,j=0;i<file.length;i++)
        {

           var f1 = file[i].split("export");
           var f2 = f1[1].split(".");
           var f3 = f2[0].split("to");
           var f4 = f3[0].split("-");
           var f5 = parseInt(f4[1]);
           var f6 = months[f5-1]; 

        PopUpWindow.document.write("<tr style='display: none' class='row "+f4[0]+"'><td>"+ f6 +" "+ f4[0]+"</td>");  
        PopUpWindow.document.write("<td><a href='/"+dir+"/"+file[i]+"' download id= 'download' >Download</a></td></tr>");     
        }

        PopUpWindow.document.write("</table></div></div>");
        PopUpWindow.document.close();
      

  }

 