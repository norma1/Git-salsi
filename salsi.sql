-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-09-2017 a las 03:58:51
-- Versión del servidor: 5.1.73-community
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `salsi`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AGREGAR_C`( in pid_locacion INT,in pdescripcion varchar(40),in pprecio float, in pcantidad int, in pid_usuario int)
BEGIN
		
	
	DECLARE IDL INT;
	DECLARE IDC INT;
	DECLARE IDT INT;	
	DECLARE EL INT;
	DECLARE ESI INT;
	DECLARE INS INT;
	DECLARE CAN2 INT;

	DECLARE SUB FLOAT;
	DECLARE SUBN FLOAT;
	DECLARE P FLOAT;

	

	SET IDL=0;	
	SET IDC=0;
	SET IDT=0;
	SET EL=0;
	SET ESI=0;
	SET INS=0;
	SET CAN2=0;

	SET SUB=0;
	SET SUBN=0;
	SET P=0;

		select max(id_sesion) into INS from t_sesiones;								
		select	estado_i into ESI from t_sesiones where estado_c=2 and id_sesion=INS;
			if ESI=1 THEN	

			select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
				if IDL > 0 then  

				select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
				if IDT > 0 then

					select estado into EL from locaciones where id_locacion=IDL;           
						if EL = 2 THEN	

							select id_complemento into IDC from complementos,locaciones,tickets where complementos.id_locacion=locaciones.id_locacion and locaciones.id_ticket=tickets.id_ticket and complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and complementos.descripcion=pdescripcion;
							if IDC > 0 then
								select cantidad into CAN2 from complementos where id_complemento=IDC;
								SET CAN2=CAN2+pcantidad;
								select precio into P from complementos where id_complemento=IDC;
								SET SUB=CAN2*P;
								SET SUBN=pcantidad*P;
								update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
								update complementos set cantidad=CAN2,subtotal=SUB where id_complemento=IDC;
								select 'La venta ha sido exitosa' as mensaje;	
							else
								SET SUB=pprecio*pcantidad;
								update tickets set subtotal=subtotal+SUB where id_ticket=IDT;
								insert into complementos values (null,pid_locacion,pdescripcion,pprecio,pcantidad,SUB,1,pid_usuario);
								select 'La venta ha sido exitosa' as mensaje;
							end if;			

					else            
					select 'El estado de la locacion no es ocupado' as mensaje;            
					end if;	

				else
				select 'El ticket no existe' as mensaje;
				end if;		

			else        
			select 'La locacion no existe' as mensaje;		
			end if;	

		else
		select 'El corte se ha hecho porfavor cierra e inicia sesion de nuevo' as mensaje;
		end if;			
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AGREGAR_E`( in pid_alimento INT,in pcantidad INT,in pprecio_u FLOAT)
BEGIN
		
	DECLARE IDA INT;	
	DECLARE EA INT;
	
	SET IDA=0;	
	SET EA=0;
	
		select id_alimento into IDA from alimentos where id_alimento=pid_alimento;
		if IDA > 0 then  

			select estado into EA from alimentos where id_alimento=pid_alimento;           
			if EA = 1 THEN

				insert into entradas values (null,pid_alimento,pcantidad,pprecio_u,current_timestamp());
				update alimentos set existencia=existencia+pcantidad where id_alimento=pid_alimento;

			else            
			select 'El alimento esta dado de baja' as mensaje;            
			end if;	

		else        
		select 'El alimento no existe' as mensaje;		
		end if;	

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AGREGAR_V`( in pcant int,in pid_alimento int,in pid_locacion int,in pid_usuario int)
BEGIN
		
	DECLARE IDA INT;		
	DECLARE IDL INT;  
	DECLARE ES INT;  
	DECLARE EL INT;        
	DECLARE EA INT;
	DECLARE RES INT;
	DECLARE ESI INT;
	DECLARE INS INT;
	DECLARE IDT INT;
	DECLARE IDV INT;
	DECLARE CAN2 INT;
	DECLARE ET INT;

	DECLARE P FLOAT;        
	DECLARE SUB FLOAT;  
	DECLARE SUBN FLOAT;      
	
		

	SET IDA=0;			
	SET IDL=0;
	SET ES=0;       
	SET EL=0;        
	SET EA=0;        
	SET RES=0;
	SET ESI=0;
	SET INS=0;
	SET IDT=0;
	SET IDV=0;
	SET CAN2=0;
	SET ET=0;

	SET SUB=0;
	SET SUBN=0;
	SET P=0;        


	
		select max(id_sesion) into INS from t_sesiones;								
		select	estado_i into ESI from t_sesiones where estado_c=2 and id_sesion=INS;
			if ESI=1 THEN

			select estado into EL from locaciones where id_locacion=pid_locacion;
				if EL = 2 THEN

				select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
					if IDL> 0 then

						select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
						if IDT > 0 then

							select estado into ET from tickets where id_ticket=IDT;
							if ET=1 then

								select id_alimento into IDA from alimentos where id_alimento=pid_alimento;
									if IDA >0 then

									select estado into EA from alimentos where pid_alimento=id_alimento;
										if EA=1 THEN

										select existencia into ES from alimentos where id_alimento=pid_alimento;
											if ES > 0 then

											SET RES= ES-pcant;
												if RES >= 0 then

												select id_venta into IDV from ventas,locaciones,tickets where ventas.id_locacion=locaciones.id_locacion and locaciones.id_ticket=tickets.id_ticket and ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and ventas.id_alimento=IDA and ventas.id_locacion=IDL;
													if IDV > 0 then
														update alimentos set existencia=RES where id_alimento=pid_alimento;
														select cantidad into CAN2 from ventas where id_venta=IDV;
														SET CAN2=CAN2+pcant;
													    select precio into P from alimentos where id_alimento=pid_alimento;
													    SET SUB=CAN2*P;	
													    SET SUBN=pcant*P;
													    update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
													    update ventas set cantidad=CAN2,subtotal=SUB where id_venta=IDV;	
													    select 'La venta ha sido exitosa' as mensaje;			                            
													else
														update alimentos set existencia=RES where id_alimento=pid_alimento;
														select precio into P from alimentos where id_alimento=pid_alimento;
														SET SUB=P*pcant;	
														update tickets set subtotal=subtotal+SUB where id_ticket=IDT;				                            
														insert into ventas values(null,pcant,pid_alimento,SUB,pid_locacion,1,pid_usuario);
														select 'La venta ha sido exitosa' as mensaje;
													end if; 

												else
												select 'La existencia es insuficiente para realizar la venta' as mensaje;
												end if;	

										    else
											select 'La existencia esta agotada' as mensaje;
											end if;

										else                       
										select 'El alimento está dado de baja' as mensaje;                         
										end if;	

									else		
									select 'El alimento no existe en el catálogo' as mensaje;		
									end if;

								else
								select 'El ticket no existe' as mensaje;
								end if;

							else
							select 'El ticket no se encuentra activo para ventas' as mensaje;
							end if;	

					else	
					select 'La locacion no existe' as mensaje;	
					end if; 

				else                   
				select 'El estado de la locacion no es ocupado' as mensaje;                  
				end if;	

			else
			select 'El corte se ha hecho porfavor cierra e inicia sesion de nuevo' as mensaje;
			end if;	 	

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CAN_C`(in pid_complemento int, in pid_locacion INT,in pcantidad int,in pid_usuario int)
BEGIN
	
	DECLARE IDC INT;		
	DECLARE IDL INT;	
	DECLARE IDT INT;
	DECLARE EL INT;   
	DECLARE ET INT; 
	DECLARE CAN INT;

	DECLARE SUB FLOAT;
	DECLARE SUBCT FLOAT;
	DECLARE SUBCOMPRO FLOAT;
	DECLARE PREC FLOAT;
	
	SET IDC=0;
	SET IDL=0;	
	SET IDT=0;
	SET EL=0;   
	SET ET=0;
	SET CAN=0;

	SET SUB=0;
	SET SUBCT=0;
	SET SUBCOMPRO=0;
	SET PREC=0;

		
		select id_complemento into IDC from complementos where id_complemento=pid_complemento;
		if IDC > 0 then

			select id_locacion into IDL from locaciones where id_locacion=pid_locacion;		
			if IDL > 0 then 

				select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
				if IDT > 0 then

					select estado into ET from tickets where id_ticket=IDT;
					if ET=1 then

						select estado into EL from locaciones where id_locacion=pid_locacion;                   
						if EL = 2 THEN   			            				
						
							select cantidad into CAN from complementos where id_complemento=IDC;
							if 	pcantidad > CAN then
								select 'No se puede cancelar mas de la cantidad vendida' as mensaje;
							else
								if CAN= pcantidad then
									select subtotal into SUBCT from complementos where id_complemento=IDC;

									update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
									update complementos set estado=2 where id_complemento=IDC;
									select 'La venta ha sido cancelada' as mensaje;
									
									select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
										if SUBCOMPRO = 0 then
											update tickets set estado=3 where id_ticket=IDT;
											update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
											select 'La locacion ha sido liberada' as mensaje;	
									end if;	
								else
									select precio into PREC from complementos where id_complemento=IDC;
									SET SUB=pcantidad*PREC;

									update complementos set cantidad=cantidad-pcantidad where id_complemento=IDC;

									update complementos set subtotal=subtotal-SUB where id_complemento=IDC;
									update tickets set subtotal=subtotal-SUB where id_ticket=IDT;	
									select 'Productos cancelados' as mensaje;
								end if;
							end if;			
						else                   
						select 'El estado de la locacion no es activo' as mensaje;                   
						end if;

					else
					select 'El ticket  se encuentra adeudado no se puede realizar algun otro cambio' as mensaje;
					end if;	

				else
				select 'El ticket no existe' as mensaje;
				end if;	

			else        
			select 'El la locacion no existe' as mensaje;		
			end if;	

		else
		select 'El complemento no existe' as mensaje;
		end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CAN_V`(in pid_venta int,in pid_alimento int ,in pid_locacion int,in pcantidad int)
BEGIN
	
	DECLARE IDV INT;
	DECLARE IDA INT;
	DECLARE IDL INT;
	DECLARE IDT INT;
	DECLARE CAN INT;
	DECLARE CANCT INT;
	DECLARE ET INT;

	DECLARE PREA FLOAT;
	DECLARE SUBN FLOAT;
	DECLARE SUBCT FLOAT;
	DECLARE SUBCOMPRO FLOAT;

	SET IDV=0;
	SET IDA=0;
	SET IDL=0;
	SET IDT=0;
	SET CAN=0;
	SET CANCT=0;
	SET ET=0;


	SET PREA=0;
	SET SUBN=0;
	SET SUBCT=0;
	SET SUBCOMPRO=0;

				select id_venta into IDV from ventas where id_venta=pid_venta;
				if IDV > 0 then

					select ventas.id_alimento into IDA from ventas,alimentos where ventas.id_alimento=alimentos.id_alimento  and ventas.id_alimento=pid_alimento group by id_alimento;
					if IDA > 0 then

						select id_locacion into IDL from ventas where id_locacion=pid_locacion group by id_locacion;
						if IDL > 0 then

							select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
							if IDT > 0 then

								select estado into ET from tickets where id_ticket=IDT;
								if ET=1 then

									select cantidad into CAN from ventas where id_venta=IDV;
									if pcantidad > CAN then
										select 'No se puede cancelar mas de la cantidad vendida' as mensaje;
									else
										if CAN = pcantidad then
											select subtotal into SUBCT from ventas where id_venta=IDV;
											select cantidad into CANCT from ventas where id_venta=IDV;

											update alimentos set existencia=existencia+CANCT where id_alimento=IDA;
											update ventas set cantidad=cantidad-CANCT where id_venta=IDV;
												
											update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
											update ventas set subtotal=subtotal-SUBCT where id_venta=IDV;	
											update ventas set estado=2 where id_venta=IDV;
											select 'La venta a sido cancelada' as mensaje;
											select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
											if SUBCOMPRO = 0 then
												update tickets set estado=3 where id_ticket=IDT;
												update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
												select 'Locacion liberada' as mensaje;	
											end if;
										else
											select precio into PREA from alimentos where id_alimento=IDA;
											SET SUBN=pcantidad*PREA;

											update alimentos set existencia=existencia+pcantidad where id_alimento=IDA;
											update ventas set cantidad=cantidad-pcantidad where id_venta=IDV;
											
											update ventas set subtotal=subtotal-SUBN where id_venta=IDV;
											update tickets set subtotal=subtotal-SUBN where id_ticket=IDT;	
											select 'Productos cancelados' as mensaje;
										end if;
									
									end if;

								else
								select 'El ticket  se encuentra adeudado no se puede realizar algun otro cambio' as mensaje;
								end if;	

							else
							select 'No cuenta con algun ticket activo o se encuentra en estado de adedudo' as mensaje;
							end if;

						else
						select 'La locacion no existe' as mensaje;
						end if;

					else
					select 'El alimento no existe' as mensaje;
					end if;

				else
				select 'La venta no existe' as mensaje;
				end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CIERRE_S`( in pid_usuario int,in pcantidad_i float,in pC_efec float,in pC_cred float)
BEGIN
	
	DECLARE CS INT;
	DECLARE EC INT;
	DECLARE EI INT;
	DECLARE IDR INT;
	DECLARE TOT FLOAT;
	DECLARE TOTE FLOAT;
	DECLARE TOTC FLOAT;
	DECLARE TOTCL FLOAT;
	DECLARE TOTF FLOAT;
	
	SET CS=0;
	SET EC=0;
	SET EI=0;
	SET IDR=0;
	SET TOT=0;
	SET TOTE=0;
	SET TOTC=0;
	SET TOTCL=0;
	SET TOTF=0;
	
			select id_role into IDR from usuarios where id_usuario=pid_usuario;
			if IDR=2 then

				select count(id_sesion) into CS from t_sesiones;
				if CS > 0 then 

					select estado_i into EI from t_sesiones where id_sesion=CS;
					select estado_c into EC from t_sesiones where id_sesion=CS;

					if EC=2 && EI=1 then 
						update t_sesiones set estado_i=2,fecha_c=current_timestamp(),estado_c=1,id_usuario_c=pid_usuario where id_sesion=CS;
						select IF(ISNULL(sum(total)),0,sum(total)) into	TOT from tickets where estado=0 and fecha between (select fecha_i from t_sesiones where id_sesion=CS) and (select fecha_c from t_sesiones where id_sesion=CS);
						select IF(ISNULL(sum(total)),0,sum(total)) into	TOTE from tickets,metodos_p where tickets.fecha between (select fecha_i from t_sesiones where id_sesion=CS) and (select fecha_c from t_sesiones where id_sesion=CS) AND tickets.estado=0 and metodos_p.id_mp=1 and tickets.id_ticket=metodos_p.id_ticket; 
						select IF(ISNULL(sum(total)),0,sum(total)) into	TOTC from tickets,metodos_p where tickets.fecha between (select fecha_i from t_sesiones where id_sesion=CS) and (select fecha_c from t_sesiones where id_sesion=CS) AND tickets.estado=0 and metodos_p.id_mp=2 and tickets.id_ticket=metodos_p.id_ticket; 
						SET TOT=TOT+pcantidad_i;
						SET TOTCL=pC_efec+pC_cred+pcantidad_i;
						SET TOTF=TOTCL-TOT;
						insert into bitacoraCor values (null,TOT,TOTCL,TOTE,TOTC,pC_efec,pC_cred,pcantidad_i,TOTF,current_timestamp(),pid_usuario);	
						select 'Corte de dia hecho' as mensaje;
					end if;

				else
				select 'La sesion no existe' as mensaje;
				end if;	

			else
			select 'No tiene los privilegios para cerrar un corte de caja' as mensaje;
			end if;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `INICIAR_S`( in pid_usuario int)
BEGIN
	
	DECLARE CS INT;
	DECLARE EC INT;
	DECLARE EI INT;
	DECLARE IDR INT;

	SET CS=0;
	SET EC=0;
	SET EI=0;
	SET IDR=0;
				select id_role into IDR from usuarios where id_usuario=pid_usuario;
				if IDR=2 then
					select max(id_sesion) into CS from t_sesiones;
					if CS > 0 then
						select estado_i into EI from t_sesiones where id_sesion=CS;
						select estado_c into EC from t_sesiones where id_sesion=CS;
						if EC=1 && EI=2 then
							insert into t_sesiones values(null,current_timestamp(),1,'0000-00-00 00:00:00',2,pid_usuario,0);
						end if;
					else
					insert into t_sesiones values(null,current_timestamp(),1,'0000-00-00 00:00:00',2,pid_usuario,0);
					end if;
				end if;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MOD_C`(in pid_complemento int, in pid_locacion INT,in pdescripcion varchar(40),in pprecio float, in pcantidad int,in pid_usuario int)
BEGIN
	
	DECLARE IDC INT;		
	DECLARE IDL INT;	
	DECLARE IDT INT;
	DECLARE EL INT;   
	DECLARE ET INT; 
	DECLARE CAN INT;

	DECLARE SUB FLOAT;
	DECLARE SUBCT FLOAT;
	DECLARE SUBCOMPRO FLOAT;
	DECLARE PREC FLOAT;
	
	SET IDC=0;
	SET IDL=0;	
	SET IDT=0;
	SET EL=0;   
	SET ET=0;
	SET CAN=0;

	SET SUB=0;
	SET SUBCT=0;
	SET SUBCOMPRO=0;
	SET PREC=0;

		
		select id_complemento into IDC from complementos where id_complemento=pid_complemento;
		if IDC > 0 then

			select id_locacion into IDL from locaciones where id_locacion=pid_locacion;		
			if IDL > 0 then 

				select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
				if IDT > 0 then

					select estado into ET from tickets where id_ticket=IDT;
					if ET=1 then

						select estado into EL from locaciones where id_locacion=pid_locacion;                   
						if EL = 2 THEN   			            				
						
							select cantidad into CAN from complementos where id_complemento=IDC;
							if 	pcantidad > CAN then
								select 'No se puede cancelar mas de la cantidad vendida' as mensaje;
							else
								if CAN= pcantidad then
									select subtotal into SUBCT from complementos where id_complemento=IDC;

									update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
									update complementos set estado=2 where id_complemento=IDC;
									
									select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
										if SUBCOMPRO = 0 then
											update tickets set estado=3 where id_ticket=IDT;
											update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;	
									end if;	
								else
									select precio into PREC from complementos where id_complemento=IDC;
									SET SUB=pcantidad*PREC;

									update complementos set cantidad=cantidad-pcantidad where id_complemento=IDC;

									update complementos set subtotal=subtotal-SUB where id_complemento=IDC;
									update tickets set subtotal=subtotal-SUB where id_complemento=IDC;	
								end if;
							end if;			
						else                   
						select 'El estado de la locacion no es activo' as mensaje;                   
						end if;

					else
					select 'El ticket  se encuentra adeudado no se puede realizar algun otro cambio' as mensaje;
					end if;	

				else
				select 'El ticket no existe' as mensaje;
				end if;	

			else        
			select 'El la locacion no existe' as mensaje;		
			end if;	

		else
		select 'El complemento no existe' as mensaje;
		end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PAGO_TICKET`(in pid_ticket INT, in pid_descuento INT,in pid_mp int,in pcantidad FLOAT,in pid_empleado int)
BEGIN
	
	DECLARE IDT INT;
	DECLARE IDD INT;
	DECLARE IDMP INT;
	DECLARE IDL INT;
	DECLARE IDLD INT;
	DECLARE ESTT INT;
	DECLARE ESTL INT;

	DECLARE TOT FLOAT;
	DECLARE TOTV FLOAT;
	DECLARE TOTC FLOAT;
	DECLARE POR FLOAT;
	DECLARE CAMBIO FLOAT;
	DECLARE DEUDA FLOAT;

	SET IDT=0;
	SET IDD=0;
	SET IDMP=0;
	SET IDL=0;
	SET IDLD=0;
	SET POR=0;
	SET ESTT=0;
	SET ESTL=0;

	SET TOT=0;
	SET TOTV=0;
	SET TOTC=0;		
	SET CAMBIO=0;
	SET DEUDA=0;


				select id_ticket into IDT from tickets where id_ticket=pid_ticket;
				if IDT > 0 then

					select estado into ESTT from tickets where id_ticket=pid_ticket;
					if ESTT = 1 then

						select id_descuento into IDD from descuentos where id_descuento=pid_descuento;
						if IDD > 0 then

							select id_mp into IDMP from metodos_de_p where id_mp=pid_mp;
							if IDMP > 0 then

								select id_locacion into IDL from locaciones where id_ticket=IDT;
								if IDL > 0 then

										select estado into ESTL from locaciones where id_locacion=IDL;
										if ESTL = 2 then

											select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV from ventas,tickets,locaciones where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and ventas.id_locacion=IDL and ventas.id_locacion=locaciones.id_locacion and tickets.id_ticket=locaciones.id_ticket;					
											select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and complementos.id_locacion=IDL and complementos.id_locacion=locaciones.id_locacion and locaciones.id_ticket=tickets.id_ticket;	
											SET TOT=TOTV+TOTC;
											select monto into POR from descuentos where id_descuento=pid_descuento;
											SET POR=POR/100;
											SET POR=TOT*POR;
											SET POR=TOT-POR;
											SET CAMBIO=POR-pcantidad;

											update tickets set id_descuento=pid_descuento where id_ticket=pid_ticket;
											update tickets set total=POR where id_ticket=pid_ticket;
											update ventas set estado=0 where id_locacion=IDL and estado=1;	
											update complementos set estado=0 where id_locacion=IDL and estado=1;

												if CAMBIO > 0 then
													update tickets set estado=2 where id_ticket=pid_ticket;
													update tickets set subtotal=CAMBIO where id_ticket=pid_ticket;
													update tickets set id_empleado=pid_empleado where id_ticket=pid_ticket;	
													insert 	into metodos_p values(null,pid_mp,pid_ticket);	
													select 'Locacion no pagada' as mensaje;

												else
													update locaciones set estado=1 where id_locacion=IDL;
													update locaciones set id_ticket=0 where id_locacion=IDL;	
													update tickets set subtotal=0 where id_ticket=pid_ticket;	
													update tickets set estado=0 where id_ticket=pid_ticket;	
													update tickets set id_empleado=pid_empleado where id_ticket=pid_ticket;		
													insert 	into metodos_p values(null,pid_mp,pid_ticket);	
                                                    if CAMBIO=0 then
															select 'Locacion Pagada' as mensaje;
                                                    else
															select ABS(CAMBIO);	
                                                    end if;

												end if;

										else
										select 'El estado de la locacion no es activa' as mensaje;
										end if;

								else
								select 'La locacion no existe';
								end if;

							else
							select 'El metodo de pago no existe' as mensaje;
							end if;

						else
						select 'El descuento no existe' as mensaje;
						end if;

					else
						if ESTT = 2 then
							select subtotal into DEUDA from tickets where id_ticket=pid_ticket and estado=2;
							SET DEUDA=DEUDA-pcantidad;
								if DEUDA > 0 then
									update tickets set subtotal=DEUDA where id_ticket=pid_ticket and estado=2;
									insert 	into metodos_p values(null,pid_mp,pid_ticket);		
								    select 'Locacion no pagada' as mensaje;

								else
									select id_locacion into IDLD from locaciones where id_ticket=IDT and estado=2;
									update locaciones set estado=1 where id_locacion=IDLD;
									update locaciones set id_ticket=0 where id_locacion=IDLD;	
									update tickets set subtotal=0 where id_ticket=pid_ticket;	
									update tickets set estado=0 where id_ticket=pid_ticket;	
									insert 	into metodos_p values(null,pid_mp,pid_ticket);
                                    if DEUDA=0 then
										select 'Locacion pagada' as mensaje;
                                    else    
										select abs(DEUDA);	
									end if;
								end if;

						else
						select 'La locacion ya es pagaga' as mensaje;
						end if;	

					end if;

				else
				select 'El ticket no existe' as mensaje;
				end if;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PAGO_TICKET2`(in pid_ticket INT, in pid_descuento INT,in pid_mp int,in pcantidad FLOAT,in pid_empleado int, OUT cambi float)
BEGIN
	
	DECLARE IDT INT;
	DECLARE IDD INT;
	DECLARE IDMP INT;
	DECLARE IDL INT;
	DECLARE IDLD INT;
	DECLARE POR INT;
	DECLARE ESTT INT;
	DECLARE ESTL INT;

	DECLARE TOT FLOAT;
	DECLARE TOTV FLOAT;
	DECLARE TOTC FLOAT;
	DECLARE CAMBIO FLOAT;
	DECLARE DEUDA FLOAT;

	SET IDT=0;
	SET IDD=0;
	SET IDMP=0;
	SET IDL=0;
	SET IDLD=0;
	SET POR=0;
	SET ESTT=0;
	SET ESTL=0;

	SET TOT=0;
	SET TOTV=0;
	SET TOTC=0;		
	SET CAMBIO=0;
	SET DEUDA=0;


				select id_ticket into IDT from tickets where id_ticket=pid_ticket;
				if IDT > 0 then
					select estado into ESTT from tickets where id_ticket=pid_ticket;
					if ESTT = 1 then
						select id_descuento into IDD from descuentos where id_descuento=pid_descuento;
						if IDD > 0 then
							select id_mp into IDMP from metodos_de_p where id_mp=pid_mp;
							if IDMP > 0 then
								select id_locacion into IDL from locaciones where id_ticket=IDT;
								if IDL > 0 then
										select estado into ESTL from locaciones where id_locacion=IDL;
										if ESTL = 2 then
											select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV from ventas,tickets,locaciones where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and ventas.id_locacion=IDL and ventas.id_locacion=locaciones.id_locacion and tickets.id_ticket=locaciones.id_ticket;					
											select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and complementos.id_locacion=IDL and complementos.id_locacion=locaciones.id_locacion and locaciones.id_ticket=tickets.id_ticket;	
											SET TOT=TOTV+TOTC;
											select monto into POR from descuentos where id_descuento=pid_descuento;
											SET POR=POR/100;
											SET POR=TOT*POR;
											SET POR=TOT-POR;
											SET CAMBIO=POR-pcantidad;

											update tickets set id_descuento=pid_descuento where id_ticket=pid_ticket;
											update tickets set total=POR where id_ticket=pid_ticket;
											update ventas set estado=0 where id_locacion=IDL and estado=1;	
											update complementos set estado=0 where id_locacion=IDL and estado=1;

												if CAMBIO > 0 then
													update tickets set estado=2 where id_ticket=pid_ticket;
													update tickets set subtotal=CAMBIO where id_ticket=pid_ticket;
													update tickets set id_empleado=pid_empleado where id_ticket=pid_ticket;	
													insert 	into metodos_p values(null,pid_mp,pid_ticket);
												else
													update locaciones set estado=1 where id_locacion=IDL;
													update locaciones set id_ticket=0 where id_locacion=IDL;	
													update tickets set subtotal=0 where id_ticket=pid_ticket;	
													update tickets set estado=0 where id_ticket=pid_ticket;	
													update tickets set id_empleado=pid_empleado where id_ticket=pid_ticket;		
													insert 	into metodos_p values(null,pid_mp,pid_ticket);	
                                                    set cambi=CAMBIO;
                                                    select abs(cambi);
												end if;
										else
										select 'El estado de la locacion no es activa' as mensaje;
										end if;
								else
								select 'La locacion no existe';
								end if;
							else
							select 'El metodo de pago no existe' as mensaje;
							end if;
						else
						select 'El descuento no existe' as mensaje;
						end if;
					else
						if ESTT = 2 then
							select subtotal into DEUDA from tickets where id_ticket=pid_ticket and estado=2;
							SET DEUDA=DEUDA-pcantidad;
								if DEUDA > 0 then
									update tickets set subtotal=DEUDA where id_ticket=pid_ticket and estado=2;
									insert 	into metodos_p values(null,pid_mp,pid_ticket);		
								else
									select id_locacion into IDLD from locaciones where id_ticket=IDT and estado=2;
									update locaciones set estado=1 where id_locacion=IDLD;
									update locaciones set id_ticket=0 where id_locacion=IDLD;	
									update tickets set subtotal=0 where id_ticket=pid_ticket;	
									update tickets set estado=0 where id_ticket=pid_ticket;	
									insert 	into metodos_p values(null,pid_mp,pid_ticket);
                                    set cambi=DEUDA;
									select abs(cambi);
								end if;

						end if;
					end if;
				else
				select 'El ticket no existe' as mensaje;
				end if;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RESERVA_C`( in pid_locacion int)
BEGIN
	DECLARE IDL INT;
	DECLARE EL INT;
	DECLARE IDT INT;
	DECLARE INS INT;
	DECLARE ESI INT;

	SET IDL=0;
	SET EL=0;
	SET IDT=0;
	SET INS=0;
	SET ESI=0;

			select max(id_sesion) into INS from t_sesiones;	
			select	estado_i into ESI from t_sesiones where estado_c=2 and id_sesion=INS;
			if ESI = 1 THEN

				select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
				if IDL > 0 THEN

					select estado into EL from locaciones where id_locacion=pid_locacion;
					if EL = 1 then

						insert into tickets values (null,0,0,current_timestamp(),0,1,0);
						select MAX(id_ticket) into IDT from tickets;
						update locaciones set id_ticket=IDT,estado=2 where id_locacion=pid_locacion;
						select 'Reservacion Exitosa' as mensaje;

					else
					select 'La locacion se encuentra ocupada' as mensaje;
					end if;

				else
				select 'La locacion no existe' as mensaje;
				end if;

			else
			select 'El corte se ha hecho porfavor cierra e inicia sesion de nuevo' as mensaje;
			end if;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE IF NOT EXISTS `alimentos` (
  `id_alimento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `id_categoria_a` int(11) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_alimento`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=131 ;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id_alimento`, `descripcion`, `precio`, `id_categoria_a`, `existencia`, `estado`) VALUES
(1, 'Ensalada de atun', 80, 1, 0, 1),
(2, 'Ensalada Pizzanlov', 80, 1, 86, 1),
(3, 'Tabla de carnes frias', 140, 2, 91, 1),
(4, 'Tabla de quesos', 140, 2, 63, 1),
(5, 'Nuggets de pollo con papas', 75, 2, 66, 1),
(6, 'Dedos de queso con papas', 75, 2, 96, 1),
(7, 'Papas a la francesa 250gr', 35, 2, 93, 1),
(8, 'Papas a la grancesa 500gr', 55, 2, 89, 1),
(9, 'Alitas media orden', 65, 3, 94, 1),
(10, 'Alitas una orden', 110, 3, 94, 1),
(11, 'Alitas orden doble', 220, 3, 82, 1),
(12, 'Pizza de queso', 110, 4, 97, 1),
(13, 'Pizza de peporoni', 130, 4, 100, 1),
(14, 'Pizza hawaiana', 130, 4, 110, 1),
(15, 'Pizza margarita', 125, 4, 99, 1),
(16, 'Pizza vegetariana', 135, 4, 100, 1),
(17, 'Pizza pastor', 160, 4, 100, 1),
(18, 'Pizza napolitana', 165, 4, 100, 1),
(19, 'Pizza pera y brie', 160, 4, 100, 1),
(20, 'Pizza 4 quesos', 170, 4, 100, 1),
(21, 'Pizza pizzanlov', 175, 4, 100, 1),
(22, 'Pizza verde', 170, 4, 100, 1),
(23, 'Tu pizza', 185, 4, 100, 1),
(24, 'Pizza de nutella y fruta', 45, 5, 99, 1),
(25, 'Pizza de mermelada y queso brie', 45, 5, 100, 1),
(26, 'Pasteleria de la casa', 50, 5, 96, 1),
(27, 'Helados', 30, 5, 100, 1),
(28, 'Cafe expreso', 25, 6, 100, 1),
(29, 'Cafe americano', 25, 6, 95, 1),
(30, 'Cafe late', 35, 6, 100, 1),
(31, 'Cafe capuchino', 35, 6, 74, 1),
(32, 'Cafe mocachino', 35, 6, 100, 1),
(33, 'Cafe frapuchino', 35, 6, 100, 1),
(34, 'Cafe affogato', 45, 6, 100, 1),
(35, 'Cafe chocolate BAILEYS', 105, 6, 100, 1),
(36, 'Cerveza1 corona', 30, 7, 100, 1),
(37, 'Cerveza1 victoria', 30, 7, 100, 1),
(38, 'Cerveza1 pacifico', 30, 7, 100, 1),
(39, 'Cerveza1 leon', 30, 7, 100, 1),
(40, 'Cerveza1 Michelada', 35, 7, 100, 1),
(41, 'Cerveza1 Cubana', 40, 7, 98, 1),
(42, 'Cerveza1 Clamato', 45, 7, 95, 1),
(43, 'Cerveza2 Modelo especial', 35, 7, 90, 1),
(44, 'Cerveza2 Negra modelo', 35, 7, 100, 1),
(45, 'Cerveza2 corona light', 35, 7, 100, 1),
(46, 'Cerveza2 Michelada', 40, 7, 100, 1),
(47, 'Cerveza2 Cubana', 45, 7, 100, 1),
(48, 'Cerveza2 Clamato', 50, 7, 100, 1),
(49, 'Coca cola', 20, 7, 100, 1),
(50, 'Coca cola light', 20, 7, 100, 1),
(51, 'fresca', 20, 7, 100, 1),
(52, 'sprite', 20, 7, 100, 1),
(53, 'sprite zero', 20, 7, 100, 1),
(54, 'sidral', 20, 7, 100, 1),
(55, 'fanta', 20, 7, 100, 1),
(56, 'delaware', 20, 7, 100, 1),
(57, 'ginger ale', 20, 7, 100, 1),
(58, 'Botella de agua', 20, 7, 98, 1),
(59, 'Canica', 30, 7, 81, 1),
(60, 'Conga', 35, 7, 100, 1),
(61, 'Clamato preparado', 35, 7, 96, 1),
(62, 'Limonada o Naranjada', 30, 7, 100, 1),
(63, 'Malteada', 40, 7, 100, 1),
(64, 'Frappe', 35, 7, 100, 1),
(65, 'Chocolate', 30, 7, 100, 1),
(66, 'Leche', 25, 7, 100, 1),
(67, 'Centenario Plata', 60, 8, 100, 1),
(68, 'Centenario Reposado', 60, 8, 98, 1),
(69, 'Don Julio', 90, 8, 100, 1),
(70, 'Don Julio 70', 105, 8, 100, 1),
(71, 'Herradura Blanco', 80, 8, 100, 1),
(72, 'Herradura Plata', 80, 8, 95, 1),
(73, 'Herradura Reposado', 90, 8, 100, 1),
(74, 'Jose Cuervo', 60, 8, 100, 1),
(75, 'Tradicional', 70, 8, 100, 1),
(76, '1800', 70, 8, 100, 1),
(77, '800 Reposado', 75, 8, 100, 1),
(78, 'Mezcla Peloton', 75, 8, 100, 1),
(79, 'Etiqueta Negra', 125, 9, 100, 1),
(80, 'Etiqueta Roja', 85, 9, 100, 1),
(81, 'Buchanans', 125, 9, 100, 1),
(82, 'Jack Daniels', 85, 9, 100, 1),
(83, 'JB', 80, 9, 94, 1),
(84, 'Absolut Azul', 80, 10, 100, 1),
(85, 'Grey Goose', 95, 10, 96, 1),
(86, 'Stolichnaya', 80, 10, 100, 1),
(87, 'Appleton Blanco', 65, 11, 100, 1),
(88, 'Appleton Especial', 65, 11, 100, 1),
(89, 'Bacardi Añejo', 65, 11, 100, 1),
(90, 'Bacardi Blanco', 65, 11, 100, 1),
(91, 'Bacardi Limon', 70, 11, 100, 1),
(92, 'Bacardi Razz', 70, 11, 100, 1),
(93, 'Flor de Caña', 65, 11, 100, 1),
(94, 'Habana Club', 65, 11, 100, 1),
(95, 'Malibu', 70, 11, 100, 1),
(96, 'Matesalem Platino', 70, 11, 100, 1),
(97, 'Azteca de Oro', 65, 12, 96, 1),
(98, 'Don Pedro', 60, 12, 66, 1),
(99, 'Fundador', 70, 12, 98, 1),
(100, 'Terry', 75, 12, 98, 1),
(101, 'Torres 10', 75, 12, 98, 1),
(102, 'Hennessy V.S.O.P', 140, 12, 95, 1),
(103, 'Beefeater', 85, 13, 95, 1),
(104, 'Larios', 70, 13, 80, 1),
(105, 'Agavero', 65, 14, 100, 1),
(106, 'Amaretto Disarono', 85, 14, 100, 1),
(107, 'Anis Chinchon Dulce', 65, 14, 100, 1),
(108, 'Anis Chinchon Seco', 65, 14, 100, 1),
(109, 'Baileys', 85, 14, 100, 1),
(110, 'Licor de Pacharan', 75, 14, 100, 1),
(111, 'Campari', 65, 14, 100, 1),
(112, 'Dubo nnet', 65, 14, 100, 1),
(113, 'Frangelico', 85, 14, 100, 1),
(114, 'Jagermaister', 85, 14, 100, 1),
(115, 'Kahlua', 55, 14, 100, 1),
(116, 'Licor 43', 95, 14, 100, 1),
(117, 'Midori', 70, 14, 100, 1),
(118, 'Sambuca Negro', 85, 14, 100, 1),
(119, 'Vermounth Rojo', 60, 14, 100, 1),
(120, 'Copa de Vino', 60, 15, 90, 1),
(121, 'Bloody Mary', 85, 16, 100, 1),
(122, 'Caipirinha', 85, 16, 98, 1),
(123, 'Mojito', 105, 16, 100, 1),
(124, 'Daikiri', 90, 16, 98, 1),
(125, 'Margarita', 105, 16, 97, 1),
(126, 'Martini', 105, 16, 100, 1),
(127, 'Paloma', 90, 16, 100, 1),
(128, 'Piña colada', 85, 16, 100, 1),
(129, 'Sol y sombra', 95, 16, 100, 1),
(130, 'Ensalada César', 50, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bcom`
--

CREATE TABLE IF NOT EXISTS `bcom` (
  `id_Bcom` int(11) NOT NULL AUTO_INCREMENT,
  `id_complementoN` int(11) DEFAULT NULL,
  `descripcionN` varchar(30) DEFAULT NULL,
  `descripcionO` varchar(30) DEFAULT NULL,
  `precioN` float DEFAULT NULL,
  `precioO` float DEFAULT NULL,
  `cantidadN` int(11) DEFAULT NULL,
  `cantidadO` int(11) DEFAULT NULL,
  `subtotalN` float DEFAULT NULL,
  `subtotalO` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuarioN` int(11) DEFAULT NULL,
  `id_usuarioO` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Bcom`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `bcom`
--

INSERT INTO `bcom` (`id_Bcom`, `id_complementoN`, `descripcionN`, `descripcionO`, `precioN`, `precioO`, `cantidadN`, `cantidadO`, `subtotalN`, `subtotalO`, `fecha`, `id_usuarioN`, `id_usuarioO`) VALUES
(1, 32, 'Tacos', 'Tacos', 10, 10, 5, 10, 100, 100, '2017-07-10 04:42:50', 2, 2),
(2, 32, 'Tacos', 'Tacos', 10, 10, 5, 5, 50, 100, '2017-07-10 04:42:50', 2, 2),
(3, 33, 'tostadas', 'tostadas', 20, 20, 3, 5, 100, 100, '2017-07-10 04:48:34', 2, 2),
(4, 33, 'tostadas', 'tostadas', 20, 20, 3, 3, 60, 100, '2017-07-10 04:48:34', 2, 2),
(5, 34, 'tacos', 'tacos', 20, 20, 3, 5, 100, 100, '2017-07-10 04:50:00', 2, 2),
(6, 34, 'tacos', 'tacos', 20, 20, 3, 3, 60, 100, '2017-07-10 04:50:00', 2, 2),
(7, 34, 'tacos', 'tacos', 20, 20, 1, 3, 60, 60, '2017-07-10 04:50:17', 2, 2),
(8, 34, 'tacos', 'tacos', 20, 20, 1, 1, 20, 60, '2017-07-10 04:50:17', 2, 2),
(9, 35, 'Tacos', 'Tacos', 20, 20, 3, 5, 100, 100, '2017-07-10 05:19:18', 2, 2),
(10, 35, 'Tacos', 'Tacos', 20, 20, 3, 3, 60, 100, '2017-07-10 05:19:18', 2, 2),
(11, 36, 'Tacos', 'Tacos', 20, 20, 10, 5, 200, 100, '2017-07-11 07:34:48', 2, 2),
(12, 36, 'Tacos', 'Tacos', 20, 20, 15, 10, 300, 200, '2017-07-11 07:46:16', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bcomc`
--

CREATE TABLE IF NOT EXISTS `bcomc` (
  `id_BcomC` int(11) NOT NULL AUTO_INCREMENT,
  `id_complementoN` int(11) DEFAULT NULL,
  `id_locacion` int(11) DEFAULT NULL,
  `descripcion` varchar(30) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuarioN` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_BcomC`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `bcomc`
--

INSERT INTO `bcomc` (`id_BcomC`, `id_complementoN`, `id_locacion`, `descripcion`, `precio`, `cantidad`, `subtotal`, `fecha`, `id_usuarioN`) VALUES
(1, 32, 1, 'Tacos', 10, 5, 50, '2017-07-10 04:42:57', 2),
(2, 33, 5, 'tostadas', 20, 3, 60, '2017-07-10 04:49:12', 2),
(3, 34, 5, 'tacos', 20, 1, 20, '2017-07-10 04:50:24', 2),
(4, 35, 5, 'Tacos', 20, 3, 60, '2017-07-10 05:19:28', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoracor`
--

CREATE TABLE IF NOT EXISTS `bitacoracor` (
  `id_bitacora` int(11) NOT NULL AUTO_INCREMENT,
  `total_c` float DEFAULT NULL,
  `total_in` float DEFAULT NULL,
  `c_efectivo` float DEFAULT NULL,
  `c_credito` float DEFAULT NULL,
  `c_efectivo_i` float DEFAULT NULL,
  `c_credito_i` float DEFAULT NULL,
  `cantidad_i` float DEFAULT NULL,
  `desfase` float DEFAULT NULL,
  `fecha_corte` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bitacora`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `bitacoracor`
--

INSERT INTO `bitacoracor` (`id_bitacora`, `total_c`, `total_in`, `c_efectivo`, `c_credito`, `c_efectivo_i`, `c_credito_i`, `cantidad_i`, `desfase`, `fecha_corte`, `id_usuario`) VALUES
(1, 3550, 4000, 1750, 600, 1000, 1000, 2000, 450, '2017-07-02 00:41:34', 2),
(2, 2295, 3000, 295, 295, 500, 500, 2000, 705, '2017-07-02 23:34:13', 2),
(3, 7585, 8000, 4465, 1120, 5500, 500, 2000, 415, '2017-07-03 23:43:47', 2),
(4, 1800, 1800, 0, 800, 0, 800, 1000, 0, '2017-07-04 00:11:59', 2),
(5, 15915, 10000, 13475, 0, 2000, 3000, 5000, -5915, '2017-07-10 04:50:50', 2),
(6, 1845, 2000, 345, 0, 500, 0, 1500, 155, '2017-07-10 05:39:20', 2),
(7, 350, 320, 150, 0, 100, 20, 200, -30, '2017-07-10 05:46:25', 2),
(8, 4246, 2500, 8888, 0, 2000, 500, 0, -1746, '2017-07-10 07:37:45', 2),
(9, 2220, 2600, 720, 485, 600, 500, 1500, 380, '2017-07-11 09:07:11', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bventas`
--

CREATE TABLE IF NOT EXISTS `bventas` (
  `id_Bventa` int(11) NOT NULL AUTO_INCREMENT,
  `id_ventaN` int(11) DEFAULT NULL,
  `cantidadN` int(11) DEFAULT NULL,
  `cantidadO` int(11) DEFAULT NULL,
  `id_alimentoN` int(11) DEFAULT NULL,
  `id_alimentoO` int(11) DEFAULT NULL,
  `id_locacionN` int(11) DEFAULT NULL,
  `id_locacionO` int(11) DEFAULT NULL,
  `subtotalN` float DEFAULT NULL,
  `subtotalO` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuarioN` int(11) DEFAULT NULL,
  `id_usuarioO` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Bventa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Volcado de datos para la tabla `bventas`
--

INSERT INTO `bventas` (`id_Bventa`, `id_ventaN`, `cantidadN`, `cantidadO`, `id_alimentoN`, `id_alimentoO`, `id_locacionN`, `id_locacionO`, `subtotalN`, `subtotalO`, `fecha`, `id_usuarioN`, `id_usuarioO`) VALUES
(1, 42, 5, 10, 11, 11, 1, 1, 2200, 2200, '2017-07-06 14:21:11', 2, 2),
(2, 42, 5, 5, 11, 11, 1, 1, 1100, 2200, '2017-07-06 14:21:11', 2, 2),
(3, 42, 7, 5, 11, 11, 1, 1, 1540, 1100, '2017-07-06 14:21:25', 2, 2),
(4, 45, 2, 1, 100, 100, 1, 1, 150, 75, '2017-07-07 17:38:52', 2, 2),
(5, 48, 4, 2, 5, 5, 1, 1, 300, 150, '2017-07-07 18:27:09', 2, 2),
(6, 56, 4, 2, 1, 1, 1, 1, 320, 160, '2017-07-10 03:08:35', 2, 2),
(7, 56, 6, 4, 1, 1, 1, 1, 480, 320, '2017-07-10 03:10:43', 2, 2),
(8, 56, 8, 6, 1, 1, 1, 1, 640, 480, '2017-07-10 03:12:54', 2, 2),
(9, 56, 10, 8, 1, 1, 1, 1, 800, 640, '2017-07-10 03:16:27', 2, 2),
(10, 56, 12, 10, 1, 1, 1, 1, 960, 800, '2017-07-10 03:19:20', 2, 2),
(11, 56, 10, 12, 1, 1, 1, 1, 960, 960, '2017-07-10 04:17:28', 2, 2),
(12, 56, 10, 10, 1, 1, 1, 1, 800, 960, '2017-07-10 04:17:28', 2, 2),
(13, 56, 5, 10, 1, 1, 1, 1, 800, 800, '2017-07-10 04:17:48', 2, 2),
(14, 56, 5, 5, 1, 1, 1, 1, 400, 800, '2017-07-10 04:17:48', 2, 2),
(15, 56, 0, 5, 1, 1, 1, 1, 400, 400, '2017-07-10 04:18:11', 2, 2),
(16, 56, 0, 0, 1, 1, 1, 1, 0, 400, '2017-07-10 04:18:11', 2, 2),
(17, 58, 1, 2, 59, 59, 1, 1, 60, 60, '2017-07-10 04:36:01', 2, 2),
(18, 58, 1, 1, 59, 59, 1, 1, 30, 60, '2017-07-10 04:36:01', 2, 2),
(19, 58, 0, 1, 59, 59, 1, 1, 30, 30, '2017-07-10 04:36:11', 2, 2),
(20, 58, 0, 0, 59, 59, 1, 1, 0, 30, '2017-07-10 04:36:11', 2, 2),
(21, 57, 12, 2, 1, 1, 1, 1, 960, 160, '2017-07-10 04:36:27', 2, 2),
(22, 57, 0, 12, 1, 1, 1, 1, 960, 960, '2017-07-10 04:38:22', 2, 2),
(23, 57, 0, 0, 1, 1, 1, 1, 0, 960, '2017-07-10 04:38:22', 2, 2),
(24, 60, 0, 5, 125, 125, 3, 3, 525, 525, '2017-07-10 05:10:04', 2, 2),
(25, 60, 0, 0, 125, 125, 3, 3, 0, 525, '2017-07-10 05:10:04', 2, 2),
(26, 61, 0, 10, 125, 125, 13, 13, 1050, 1050, '2017-07-10 05:11:25', 2, 2),
(27, 61, 0, 0, 125, 125, 13, 13, 0, 1050, '2017-07-10 05:11:25', 2, 2),
(28, 70, 10, 10, 59, 59, 1, 1, 300, 300, '2017-07-10 06:26:24', 2, 2),
(29, 70, 10, 10, 59, 59, 1, 1, 300, 300, '2017-07-10 06:28:56', 2, 2),
(30, 95, 0, 2, 20, 20, 5, 5, 340, 340, '2017-07-11 05:48:40', 2, 2),
(31, 95, 0, 0, 20, 20, 5, 5, 0, 340, '2017-07-11 05:48:41', 2, 2),
(32, 96, 7, 2, 35, 35, 5, 5, 735, 210, '2017-07-11 06:28:40', 2, 2),
(33, 96, 0, 7, 35, 35, 5, 5, 735, 735, '2017-07-11 06:44:29', 2, 2),
(34, 96, 0, 0, 35, 35, 5, 5, 0, 735, '2017-07-11 06:44:29', 2, 2),
(35, 97, 2, 4, 61, 61, 5, 5, 140, 140, '2017-07-11 07:05:59', 2, 2),
(36, 97, 2, 2, 61, 61, 5, 5, 70, 140, '2017-07-11 07:05:59', 2, 2),
(37, 97, 4, 2, 61, 61, 5, 5, 140, 70, '2017-07-11 07:21:53', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bventasc`
--

CREATE TABLE IF NOT EXISTS `bventasc` (
  `id_BventasC` int(11) NOT NULL AUTO_INCREMENT,
  `id_ventaN` int(11) DEFAULT NULL,
  `cantidadN` int(11) DEFAULT NULL,
  `id_alimentoN` int(11) DEFAULT NULL,
  `subtotalN` float DEFAULT NULL,
  `id_locacionN` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuarioN` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_BventasC`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `bventasc`
--

INSERT INTO `bventasc` (`id_BventasC`, `id_ventaN`, `cantidadN`, `id_alimentoN`, `subtotalN`, `id_locacionN`, `fecha`, `id_usuarioN`) VALUES
(1, 53, 2, 5, 150, 1, '2017-07-10 02:25:02', 2),
(2, 54, 10, 124, 900, 1, '2017-07-10 02:25:11', 2),
(3, 55, 5, 6, 375, 4, '2017-07-10 02:48:57', 2),
(4, 56, 0, 1, 0, 1, '2017-07-10 04:18:11', 2),
(5, 58, 0, 59, 0, 1, '2017-07-10 04:36:11', 2),
(6, 57, 0, 1, 0, 1, '2017-07-10 04:38:22', 2),
(7, 60, 0, 125, 0, 3, '2017-07-10 05:10:04', 2),
(8, 61, 0, 125, 0, 13, '2017-07-10 05:11:25', 2),
(9, 95, 0, 20, 0, 5, '2017-07-11 05:48:41', 2),
(10, 96, 0, 35, 0, 5, '2017-07-11 06:44:29', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_a`
--

CREATE TABLE IF NOT EXISTS `categorias_a` (
  `id_categoria_a` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(35) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_categoria_a`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `categorias_a`
--

INSERT INTO `categorias_a` (`id_categoria_a`, `descripcion`, `estado`) VALUES
(1, 'Ensaladas', 1),
(2, 'Botana', 1),
(3, 'Alitas', 1),
(4, 'Pizza', 1),
(5, 'Postre', 1),
(6, 'Cafe', 1),
(7, 'Bebida', 1),
(8, 'Tequila y Mezcales', 1),
(9, 'Whisky', 1),
(10, 'Vodka', 1),
(11, 'Ron', 1),
(12, 'Brandy y Cognac', 1),
(13, 'Ginebra', 1),
(14, 'Licores', 1),
(15, 'Vino', 1),
(16, 'Cocteles', 1),
(17, 'Sugerencias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `complementos`
--

CREATE TABLE IF NOT EXISTS `complementos` (
  `id_complemento` int(11) NOT NULL AUTO_INCREMENT,
  `id_locacion` int(11) DEFAULT NULL,
  `descripcion` varchar(80) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_complemento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Volcado de datos para la tabla `complementos`
--

INSERT INTO `complementos` (`id_complemento`, `id_locacion`, `descripcion`, `precio`, `cantidad`, `subtotal`, `estado`, `id_usuario`) VALUES
(1, 10, 'Perla negra', 200, 5, 1000, 2, 2),
(2, 10, 'Tacos', 200, 1, 200, 2, 2),
(3, 10, 'Enchiladas', 100, 2, 200, 2, 2),
(4, 1, 'Tacos', 200, 1, 200, 0, 2),
(5, 1, 'Tacos', 200, 1, 200, 0, 2),
(6, 1, 'Tacos', 200, 1, 200, 0, 2),
(7, 1, 'Tacos', 200, 1, 200, 0, 2),
(8, 5, 'Tacos', 200, 1, 200, 0, 2),
(9, 5, 'Tacos', 200, 1, 200, 0, 2),
(10, 5, 'Tacos', 200, 1, 200, 0, 2),
(11, 1, 'Tacos', 20, 2, 40, 0, 2),
(12, 1, 'Enchiladas', 15, 2, 30, 2, 2),
(13, 1, 'Perla negra', 200, 1, 200, 2, 2),
(14, 2, 'Pepitas', 10, 1, 10, 2, 2),
(15, 1, 'Tacos', 20, 2, 40, 0, 2),
(16, 1, 'spiner', 15, 2, 30, 0, 2),
(17, 1, 'Perla Negra', 100, 5, 500, 0, 2),
(18, 1, 'shot mesclas negras', 150, 4, 600, 0, 2),
(19, 1, 'spiner', 15, 1, 15, 0, 2),
(20, 1, 'spiner', 20, 1, 20, 0, 2),
(21, 1, 'perla negra', 200, 1, 200, 0, 2),
(22, 1, 'Tacos', 20, 5, 100, 0, 2),
(23, 1, 'tacos', 20, 5, 100, 0, 2),
(24, 1, 'tostadas', 15, 2, 30, 0, 2),
(25, 1, 'tacos', 20, 2, 40, 0, 2),
(26, 1, 'tacos', 20, 2, 40, 0, 2),
(27, 1, 'Tacos', 20, 5, 100, 0, 2),
(28, 1, 'TACOS', 50, 1, 50, 0, 2),
(29, 1, 'Tacos', 20, 2, 40, 0, 2),
(30, 1, 'TACOS', 20, 2, 40, 0, 2),
(31, 1, 'Tostadas', 20, 2, 40, 0, 2),
(32, 1, 'Tacos', 10, 5, 50, 2, 2),
(33, 5, 'tostadas', 20, 3, 60, 2, 2),
(34, 5, 'tacos', 20, 1, 20, 2, 2),
(35, 5, 'Tacos', 20, 3, 60, 2, 2),
(36, 5, 'Tacos', 20, 15, 300, 0, 2),
(37, 5, 'Tostadas', 15, 3, 45, 0, 2),
(38, 2, 'carajillo', 100, 2, 200, 0, 2);

--
-- Disparadores `complementos`
--
DROP TRIGGER IF EXISTS `Bc`;
DELIMITER //
CREATE TRIGGER `Bc` AFTER UPDATE ON `complementos`
 FOR EACH ROW BEGIN			
		if new.estado = 2 then            
		INSERT INTO BcomC values(null,new.id_complemento,new.id_locacion,new.descripcion,new.precio,new.cantidad,new.subtotal,current_timestamp(),new.id_usuario);
           	else				
			if new.estado = 1 then                
			INSERT INTO Bcom values(null,new.id_complemento,new.descripcion,old.descripcion,new.precio,old.precio,new.cantidad,old.cantidad,new.subtotal,old.subtotal,current_timestamp(),new.id_usuario,old.id_usuario);                
			end if;            
		end if;        
	END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE IF NOT EXISTS `descuentos` (
  `id_descuento` int(11) NOT NULL AUTO_INCREMENT,
  `monto` float DEFAULT NULL,
  PRIMARY KEY (`id_descuento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id_descuento`, `monto`) VALUES
(1, 0),
(2, 5),
(3, 10),
(4, 15),
(5, 20),
(6, 25),
(7, 30),
(8, 35),
(9, 40),
(10, 45),
(11, 50),
(12, 55),
(13, 60),
(14, 65),
(15, 70),
(16, 75),
(17, 80),
(18, 85),
(19, 90),
(20, 95),
(21, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(35) DEFAULT NULL,
  `ap` varchar(35) DEFAULT NULL,
  `am` varchar(35) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `ap`, `am`, `telefono`) VALUES
(1, 'Raziel de Jesus', 'Menchaca', 'Puch', '7221314667'),
(2, 'César ', 'Primero', 'Huerta', '7225681023');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE IF NOT EXISTS `entradas` (
  `id_entrada` int(11) NOT NULL AUTO_INCREMENT,
  `id_alimento` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_u` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_entrada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id_entrada`, `id_alimento`, `cantidad`, `precio_u`, `fecha`) VALUES
(1, 14, 10, 110, '2017-07-02 03:42:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locaciones`
--

CREATE TABLE IF NOT EXISTS `locaciones` (
  `id_locacion` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(35) DEFAULT NULL,
  `id_tipo_l` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_locacion`),
  UNIQUE KEY `numero` (`numero`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `locaciones`
--

INSERT INTO `locaciones` (`id_locacion`, `numero`, `id_tipo_l`, `id_ticket`, `estado`) VALUES
(1, '1', 1, 115, 1),
(2, '2', 1, 0, 1),
(3, '3', 1, 0, 1),
(4, '4', 1, 0, 1),
(5, '5', 1, 0, 1),
(6, '6', 2, 0, 1),
(7, '7', 2, 0, 1),
(8, '8', 2, 0, 1),
(9, '9', 2, 0, 1),
(10, '10', 2, 0, 1),
(11, '11', 3, 0, 1),
(12, '12', 3, 0, 3),
(13, '13', 3, 0, 1),
(14, '14', 3, 0, 1),
(15, '15', 3, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_de_p`
--

CREATE TABLE IF NOT EXISTS `metodos_de_p` (
  `id_mp` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_mp`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `metodos_de_p`
--

INSERT INTO `metodos_de_p` (`id_mp`, `descripcion`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta de credito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_p`
--

CREATE TABLE IF NOT EXISTS `metodos_p` (
  `id_metodo_p` int(11) NOT NULL AUTO_INCREMENT,
  `id_mp` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_metodo_p`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Volcado de datos para la tabla `metodos_p`
--

INSERT INTO `metodos_p` (`id_metodo_p`, `id_mp`, `id_ticket`) VALUES
(1, 1, 9),
(2, 1, 10),
(3, 1, 11),
(4, 2, 11),
(5, 2, 12),
(6, 1, 12),
(7, 1, 13),
(8, 1, 14),
(9, 1, 15),
(10, 1, 15),
(11, 2, 16),
(12, 1, 16),
(13, 1, 17),
(14, 2, 17),
(15, 1, 22),
(16, 1, 23),
(17, 1, 24),
(18, 1, 25),
(19, 1, 26),
(20, 1, 27),
(21, 1, 28),
(22, 1, 29),
(23, 1, 30),
(24, 1, 31),
(25, 2, 32),
(26, 2, 33),
(27, 1, 34),
(28, 1, 35),
(29, 1, 36),
(30, 1, 37),
(31, 1, 38),
(32, 1, 39),
(33, 1, 40),
(34, 1, 41),
(35, 1, 42),
(36, 1, 43),
(37, 1, 44),
(38, 1, 45),
(39, 1, 45),
(40, 1, 46),
(41, 1, 47),
(42, 1, 48),
(43, 1, 49),
(44, 1, 50),
(45, 1, 51),
(46, 1, 52),
(47, 1, 53),
(48, 1, 53),
(49, 1, 54),
(50, 1, 55),
(51, 1, 56),
(52, 1, 57),
(53, 1, 58),
(54, 1, 59),
(55, 1, 59),
(56, 1, 59),
(57, 1, 60),
(58, 1, 60),
(59, 1, 60),
(60, 1, 60),
(61, 1, 60),
(62, 1, 61),
(63, 1, 62),
(64, 1, 63),
(65, 1, 68),
(66, 1, 75),
(67, 1, 76),
(68, 1, 77),
(69, 2, 78),
(70, 1, 79),
(71, 1, 80),
(72, 1, 81),
(73, 1, 82),
(74, 1, 82),
(75, 1, 82),
(76, 1, 83),
(77, 1, 83),
(78, 1, 83),
(79, 1, 83),
(80, 1, 83),
(81, 1, 83),
(82, 1, 83),
(83, 1, 83),
(84, 1, 84),
(85, 1, 85),
(86, 1, 85),
(87, 1, 86),
(88, 1, 87),
(89, 1, 87),
(90, 1, 87),
(91, 1, 87),
(92, 1, 88),
(93, 1, 89),
(94, 1, 90),
(95, 1, 90),
(96, 1, 90),
(97, 1, 91),
(98, 1, 91),
(99, 1, 92),
(100, 1, 92),
(101, 1, 93),
(102, 1, 93),
(103, 1, 94),
(104, 1, 95),
(105, 1, 95),
(106, 1, 95),
(107, 1, 96),
(108, 1, 96),
(109, 1, 97),
(110, 1, 98),
(111, 1, 99),
(112, 1, 99),
(113, 1, 99),
(114, 1, 100),
(115, 1, 101),
(116, 1, 102),
(117, 1, 102),
(118, 1, 102),
(119, 1, 103),
(120, 1, 104),
(121, 1, 105),
(122, 1, 105),
(123, 1, 106),
(124, 1, 107),
(125, 1, 109),
(126, 2, 109),
(127, 1, 110),
(128, 1, 111),
(129, 1, 112),
(130, 1, 113),
(131, 1, 114);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id_role`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `total` float DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_empleado` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_descuento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ticket`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id_ticket`, `total`, `subtotal`, `fecha`, `id_empleado`, `estado`, `id_descuento`) VALUES
(1, 0, 0, '2017-07-01 08:43:51', 0, 0, 0),
(2, 0, 0, '2017-07-01 08:56:48', 0, 0, 0),
(3, 0, 0, '2017-07-01 09:09:53', 0, 1, 0),
(4, 0, 0, '2017-07-01 09:09:58', 0, 1, 0),
(5, 0, 0, '2017-07-01 18:45:10', 0, 3, 0),
(6, 0, 0, '2017-07-01 18:55:49', 0, 3, 0),
(7, 0, 0, '2017-07-01 19:05:29', 0, 3, 0),
(8, 0, 0, '2017-07-01 19:41:03', 0, 3, 0),
(9, 150, 0, '2017-07-01 20:47:57', 1, 0, 1),
(10, 200, 0, '2017-07-01 23:33:04', 1, 0, 1),
(11, 200, 0, '2017-07-02 00:09:09', 1, 0, 1),
(12, 200, 0, '2017-07-02 00:11:29', 1, 0, 1),
(13, 200, 0, '2017-07-02 00:17:53', 1, 0, 1),
(14, 200, 0, '2017-07-02 00:23:23', 1, 0, 1),
(15, 200, 0, '2017-07-02 00:24:10', 1, 0, 1),
(16, 200, 0, '2017-07-02 00:29:21', 1, 0, 1),
(17, 295, 0, '2017-07-02 07:52:47', 1, 0, 1),
(18, 0, 0, '2017-07-02 22:45:19', 0, 3, 0),
(19, 0, 0, '2017-07-02 22:51:25', 0, 3, 0),
(20, 0, 0, '2017-07-02 22:52:19', 0, 3, 0),
(21, 0, 0, '2017-07-02 23:04:26', 0, 3, 0),
(22, 40, 0, '2017-07-03 16:11:17', 1, 0, 1),
(23, 110, 0, '2017-07-03 16:37:41', 1, 0, 1),
(24, 30, 0, '2017-07-03 16:46:24', 1, 0, 1),
(25, 2610, 0, '2017-07-03 18:03:57', 1, 0, 1),
(26, 15, 0, '2017-07-03 21:16:50', 1, 0, 1),
(27, 20, 0, '2017-07-03 21:18:42', 1, 0, 1),
(28, 130, 0, '2017-07-03 21:20:47', 1, 0, 1),
(29, 120, 0, '2017-07-03 21:22:29', 1, 0, 1),
(30, 400, 0, '2017-07-03 21:23:45', 1, 0, 1),
(31, 990, 0, '2017-07-03 21:27:41', 1, 0, 1),
(32, 1120, 0, '2017-07-03 21:31:30', 1, 0, 1),
(33, 800, 0, '2017-07-03 23:55:15', 1, 0, 1),
(34, 100, 0, '2017-07-04 14:07:35', 1, 0, 1),
(35, 30, 0, '2017-07-04 14:09:34', 1, 0, 1),
(36, 40, 0, '2017-07-04 14:12:09', 1, 0, 1),
(37, 40, 0, '2017-07-04 14:13:29', 1, 0, 1),
(38, 4350, 0, '2017-07-04 14:40:36', 1, 0, 1),
(39, 50, 0, '2017-07-04 17:14:58', 1, 0, 1),
(40, 40, 0, '2017-07-04 17:17:38', 1, 0, 1),
(41, 40, 0, '2017-07-04 17:18:51', 1, 0, 1),
(42, 40, 0, '2017-07-04 17:19:54', 1, 0, 1),
(43, 130, 0, '2017-07-04 17:39:42', 1, 0, 1),
(44, 220, 0, '2017-07-04 17:43:08', 1, 0, 1),
(45, 0, 0, '2017-07-04 17:50:45', 1, 0, 1),
(46, 280, 0, '2017-07-04 17:56:16', 1, 0, 1),
(47, 80, 0, '2017-07-04 17:58:18', 1, 0, 1),
(48, 45, 0, '2017-07-04 17:59:40', 1, 0, 1),
(49, 150, 0, '2017-07-04 18:01:41', 1, 0, 1),
(50, 100, 0, '2017-07-04 18:04:30', 1, 0, 1),
(51, 440, 0, '2017-07-04 18:07:14', 1, 0, 1),
(52, 100, 0, '2017-07-04 18:31:48', 1, 0, 1),
(53, 1540, 0, '2017-07-06 14:20:46', 1, 0, 1),
(54, 55, 0, '2017-07-07 17:32:47', 1, 0, 1),
(55, 60, 0, '2017-07-07 17:35:24', 2, 0, 1),
(56, 150, 0, '2017-07-07 17:38:19', 1, 0, 1),
(57, 150, 0, '2017-07-07 17:40:21', 1, 0, 1),
(58, 700, 0, '2017-07-07 17:41:24', 1, 0, 1),
(59, 300, 0, '2017-07-07 18:26:57', 1, 0, 1),
(60, 105, 0, '2017-07-07 18:32:28', 1, 0, 1),
(61, 135, 0, '2017-07-07 18:39:43', 1, 0, 1),
(62, 90, 0, '2017-07-07 18:40:35', 1, 0, 1),
(63, 315, 0, '2017-07-07 18:41:41', 1, 0, 1),
(64, 0, 0, '2017-07-07 21:54:02', 0, 3, 0),
(65, 0, 0, '2017-07-10 02:35:00', 0, 3, 0),
(66, 0, 0, '2017-07-10 02:52:53', 0, 3, 0),
(67, 0, 0, '2017-07-10 04:33:09', 0, 3, 0),
(68, 1040, 0, '2017-07-10 04:38:36', 1, 0, 1),
(69, 0, 0, '2017-07-10 04:42:15', 0, 3, 0),
(70, 0, 0, '2017-07-10 04:48:11', 0, 3, 0),
(71, 0, 0, '2017-07-10 04:49:25', 0, 3, 0),
(72, 0, 0, '2017-07-10 05:05:51', 0, 3, 0),
(73, 0, 0, '2017-07-10 05:10:58', 0, 3, 0),
(74, 0, 0, '2017-07-10 05:18:49', 0, 3, 0),
(75, 40, 0, '2017-07-10 05:22:44', 2, 0, 1),
(76, 180, 0, '2017-07-10 05:27:25', 1, 0, 1),
(77, 125, 0, '2017-07-10 05:29:04', 1, 0, 1),
(78, 0, 0, '2017-07-10 05:44:14', 1, 0, 11),
(79, 150, 0, '2017-07-10 05:45:06', 1, 0, 1),
(80, 0, 0, '2017-07-10 05:48:19', 1, 0, 11),
(81, 0, 0, '2017-07-10 05:54:34', 1, 0, 11),
(82, 1, 0, '2017-07-10 05:56:02', 1, 0, 11),
(83, 0, 0, '2017-07-10 06:06:28', 1, 0, 11),
(84, 0, 0, '2017-07-10 06:37:02', 1, 0, 1),
(85, 220, 0, '2017-07-10 06:41:31', 1, 0, 1),
(86, 300, 0, '2017-07-10 06:43:41', 2, 0, 1),
(87, 700, 0, '2017-07-10 06:47:13', 2, 0, 1),
(88, 120, 0, '2017-07-10 06:52:00', 1, 0, 1),
(89, 65, 0, '2017-07-10 06:52:41', 2, 0, 11),
(90, 120, 0, '2017-07-10 06:58:25', 2, 0, 1),
(91, 900, 0, '2017-07-10 07:07:49', 1, 0, 1),
(92, 60, 0, '2017-07-10 07:10:13', 1, 0, 1),
(93, 120, 0, '2017-07-10 07:11:27', 1, 0, 1),
(94, 70, 0, '2017-07-10 07:12:32', 1, 0, 1),
(95, 70, 0, '2017-07-10 07:14:15', 1, 0, 1),
(96, 255, 0, '2017-07-10 07:17:51', 1, 0, 1),
(97, 65, 0, '2017-07-10 07:21:07', 1, 0, 1),
(98, 120, 0, '2017-07-10 07:23:44', 2, 0, 1),
(99, 150, 0, '2017-07-10 07:25:40', 2, 0, 1),
(100, 120, 0, '2017-07-10 07:27:12', 1, 0, 1),
(101, 70, 0, '2017-07-10 07:28:02', 1, 0, 11),
(102, 120, 0, '2017-07-10 07:31:16', 1, 0, 1),
(103, 150, 0, '2017-07-10 07:32:47', 1, 0, 1),
(104, 170, 0, '2017-07-10 07:33:56', 1, 0, 1),
(105, 65, 0, '2017-07-10 07:34:45', 1, 0, 1),
(106, 75, 0, '2017-07-10 07:35:39', 2, 0, 11),
(107, 140, 0, '2017-07-10 07:36:36', 1, 0, 11),
(108, 0, 0, '2017-07-11 04:01:08', 0, 3, 0),
(109, 485, 0, '2017-07-11 05:55:28', 1, 0, 1),
(110, 175, 0, '2017-07-11 08:30:46', 1, 0, 1),
(111, 60, 0, '2017-07-11 08:34:00', 2, 0, 11),
(112, 0, 0, '2017-07-11 08:41:43', 1, 0, 1),
(113, 70, 0, '2017-09-05 19:17:52', 1, 0, 1),
(114, 370, 0, '2017-09-05 19:46:01', 2, 0, 1),
(115, 0, 0, '2017-09-13 18:42:52', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_l`
--

CREATE TABLE IF NOT EXISTS `tipos_l` (
  `id_tipo_l` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_l`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipos_l`
--

INSERT INTO `tipos_l` (`id_tipo_l`, `descripcion`) VALUES
(1, 'Barra'),
(2, 'Mesa'),
(3, 'Terraza'),
(4, 'vip');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_sesiones`
--

CREATE TABLE IF NOT EXISTS `t_sesiones` (
  `id_sesion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_i` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado_i` int(11) DEFAULT NULL,
  `fecha_c` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_c` int(11) DEFAULT NULL,
  `id_usuario_i` int(11) DEFAULT NULL,
  `id_usuario_c` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sesion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `t_sesiones`
--

INSERT INTO `t_sesiones` (`id_sesion`, `fecha_i`, `estado_i`, `fecha_c`, `estado_c`, `id_usuario_i`, `id_usuario_c`) VALUES
(1, '2017-07-01 08:43:45', 2, '2017-07-02 00:41:34', 1, 2, 2),
(2, '2017-07-02 06:32:06', 2, '2017-07-02 23:34:12', 1, 2, 2),
(3, '2017-07-02 23:46:49', 2, '2017-07-03 23:43:47', 1, 2, 2),
(4, '2017-07-03 23:55:09', 2, '2017-07-04 00:11:59', 1, 2, 2),
(5, '2017-07-04 14:07:25', 2, '2017-07-10 04:50:50', 1, 2, 2),
(6, '2017-07-10 05:05:44', 2, '2017-07-10 05:39:20', 1, 2, 2),
(7, '2017-07-10 05:41:56', 2, '2017-07-10 05:46:25', 1, 2, 2),
(8, '2017-07-10 05:48:06', 2, '2017-07-10 07:37:45', 1, 2, 2),
(9, '2017-07-10 20:43:54', 2, '2017-07-11 09:07:11', 1, 2, 2),
(10, '2017-09-05 19:17:42', 1, '0000-00-00 00:00:00', 2, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `contraseña`, `id_role`) VALUES
(1, 'puch', 'puchito', 1),
(2, 'capi', '123456', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) DEFAULT NULL,
  `id_alimento` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `id_locacion` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_venta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `cantidad`, `id_alimento`, `subtotal`, `id_locacion`, `estado`, `id_usuario`) VALUES
(1, 2, 10, 220, 1, 2, 2),
(2, 7, 11, 1540, 1, 4, 2),
(3, 2, 11, 440, 2, 4, 2),
(4, 2, 11, 440, 1, 2, 2),
(5, 4, 10, 440, 1, 2, 2),
(6, 2, 10, 220, 2, 2, 2),
(7, 2, 5, 150, 2, 2, 2),
(8, 2, 5, 150, 4, 2, 2),
(9, 4, 6, 300, 4, 2, 2),
(10, 2, 6, 150, 6, 2, 2),
(11, 2, 6, 150, 6, 2, 2),
(12, 2, 6, 150, 1, 0, 2),
(13, 1, 15, 125, 1, 0, 2),
(14, 2, 9, 130, 1, 0, 2),
(15, 1, 7, 35, 1, 2, 2),
(16, 1, 28, 25, 2, 2, 2),
(17, 2, 9, 130, 1, 2, 2),
(18, 1, 12, 110, 1, 0, 2),
(19, 7, 3, 980, 1, 0, 2),
(20, 4, 85, 380, 1, 0, 2),
(21, 2, 101, 150, 1, 0, 2),
(22, 2, 9, 130, 1, 0, 2),
(23, 2, 68, 120, 1, 0, 2),
(24, 5, 72, 400, 1, 0, 2),
(25, 4, 10, 440, 1, 0, 2),
(26, 10, 43, 350, 1, 0, 2),
(27, 14, 2, 1120, 1, 0, 2),
(28, 2, 10, 220, 1, 0, 2),
(29, 6, 83, 480, 1, 0, 2),
(30, 10, 5, 750, 1, 0, 2),
(31, 25, 4, 3500, 1, 0, 2),
(32, 2, 9, 130, 1, 0, 2),
(33, 2, 10, 220, 1, 0, 2),
(34, 10, 4, 1400, 1, 0, 2),
(35, 2, 4, 280, 1, 0, 2),
(36, 2, 41, 80, 1, 0, 2),
(37, 1, 24, 45, 1, 0, 2),
(38, 2, 5, 150, 1, 0, 2),
(39, 2, 26, 100, 1, 0, 2),
(40, 2, 11, 440, 1, 0, 2),
(41, 2, 26, 100, 1, 0, 2),
(42, 7, 11, 1540, 1, 0, 2),
(43, 1, 8, 55, 1, 0, 2),
(44, 2, 59, 60, 1, 0, 2),
(45, 2, 100, 150, 1, 0, 2),
(46, 5, 59, 150, 1, 0, 2),
(47, 5, 102, 700, 1, 0, 2),
(48, 4, 5, 300, 1, 0, 2),
(49, 3, 7, 105, 1, 0, 2),
(50, 3, 42, 135, 1, 0, 2),
(51, 2, 42, 90, 1, 0, 2),
(52, 3, 125, 315, 1, 0, 2),
(53, 2, 5, 150, 1, 2, 2),
(54, 10, 124, 900, 1, 2, 2),
(55, 5, 6, 375, 4, 2, 2),
(56, 0, 1, 0, 1, 2, 2),
(57, 0, 1, 0, 1, 2, 2),
(58, 0, 59, 0, 1, 2, 2),
(59, 13, 1, 1040, 1, 0, 2),
(60, 0, 125, 0, 3, 2, 2),
(61, 0, 125, 0, 13, 2, 2),
(62, 2, 58, 40, 5, 0, 2),
(63, 2, 124, 180, 5, 0, 2),
(64, 5, 29, 125, 5, 0, 2),
(65, 5, 120, 300, 5, 0, 2),
(66, 2, 5, 150, 5, 0, 2),
(67, 20, 98, 1200, 2, 0, 2),
(68, 10, 104, 700, 3, 0, 2),
(69, 20, 31, 700, 3, 0, 2),
(70, 10, 59, 300, 1, 0, 2),
(71, 10, 8, 550, 3, 0, 2),
(72, 2, 12, 220, 3, 0, 2),
(73, 5, 120, 300, 3, 0, 2),
(74, 10, 104, 700, 3, 0, 2),
(75, 2, 98, 120, 3, 0, 2),
(76, 2, 97, 130, 3, 0, 2),
(77, 2, 98, 120, 3, 0, 2),
(78, 12, 5, 900, 3, 0, 2),
(79, 2, 59, 60, 3, 0, 2),
(80, 2, 98, 120, 3, 0, 2),
(81, 2, 31, 70, 3, 0, 2),
(82, 2, 31, 70, 3, 0, 2),
(83, 3, 103, 255, 3, 0, 2),
(84, 1, 97, 65, 3, 0, 2),
(85, 2, 98, 120, 3, 0, 2),
(86, 2, 5, 150, 3, 0, 2),
(87, 2, 98, 120, 3, 0, 2),
(88, 2, 99, 140, 3, 0, 2),
(89, 2, 98, 120, 3, 0, 2),
(90, 2, 6, 150, 3, 0, 2),
(91, 2, 122, 170, 3, 0, 2),
(92, 1, 97, 65, 3, 0, 2),
(93, 2, 5, 150, 3, 0, 2),
(94, 2, 3, 280, 3, 0, 2),
(95, 0, 20, 0, 5, 2, 2),
(96, 0, 35, 0, 5, 2, 2),
(97, 4, 61, 140, 5, 0, 2),
(98, 5, 7, 175, 5, 0, 2),
(99, 2, 98, 120, 5, 0, 2),
(100, 2, 31, 70, 2, 0, 2),
(101, 2, 103, 170, 2, 0, 2);

--
-- Disparadores `ventas`
--
DROP TRIGGER IF EXISTS `Bv`;
DELIMITER //
CREATE TRIGGER `Bv` AFTER UPDATE ON `ventas`
 FOR EACH ROW BEGIN 				
		if new.estado = 2 then                
		INSERT INTO BventasC values (null,new.id_venta,new.cantidad,new.id_alimento,new.subtotal,new.id_locacion,current_timestamp(),new.id_usuario);                
		else					
			if new.estado =1 then					
			INSERT INTO Bventas values(null,new.id_venta,new.cantidad,old.cantidad,new.id_alimento,old.id_alimento,new.id_locacion,old.id_locacion,new.subtotal,old.subtotal,current_timestamp(),new.id_usuario,old.id_usuario);
                    	end if;                
		end if;	
	END
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
