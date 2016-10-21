select All_Products.*, Manufacturers.*
from All_Products
join Manufacturers
  on Manufacturers.ManuCode like concat(All_Products.MFRCode,'%') WHERE Manufacturers.MfgName LIKE '%'"ABBOTT"'%'
