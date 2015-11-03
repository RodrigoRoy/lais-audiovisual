# Indicar con que base de datos trabajar
USE Audiovisuales;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Script para borrar documentales de la década 10 (1980) que aun no está definido su catalogación exacta:
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-48';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-49';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-50';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-51';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-52';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-53';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-54';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-55';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-56';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-57';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-58';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-59';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-60';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-61';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-62';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-63';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-64';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-10-65';