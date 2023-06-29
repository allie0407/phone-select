</td></tr>
<!--footer-->
<tr><td colspan="2" align="center" height="20" bgcolor="#147ce3">Copyright © Chong Wei Xin 2023</td></tr>
</table>
<script type="text/javascript">
    //skrip untuk cetak bahagian khas kandungan sahaja
    //arahan print biasa akan cetak keseluruhan halaman
    function printcontent(areaID){
        var printContent=document.getElemenById(areaID);
        var WinPrint=window.open('','','width=900, height=650');
        WinPrint.document.write(printContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
    </script>
    </body>
    <html>