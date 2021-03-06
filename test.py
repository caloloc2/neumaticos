import cv2
import os, time

directorio = 'llantas/'

while(True):
	archivo = open("php/inicia_camara.txt", "r")
	inicia = archivo.read()
	archivo.close() 
	
	if (inicia=='1'):
		os.system('clear')		
		print("Proceso iniciado...")
		path, dirs, files = next(os.walk(directorio))
		file_count = len(files)
		numero_archivo = 1

		if (file_count==0):
			numero_archivo = 1
		elif (file_count==3):
			numero_archivo = 2
		elif (file_count>3):
			numero_archivo = (file_count / 3)+1  # obtiene el numero de imagen que tocaria
		foto_normal = "foto_"+str(numero_archivo)+".jpg"
		foto_procesada = "proc_"+str(numero_archivo)+".jpg"
		foto_gris = "gris_"+str(numero_archivo)+".jpg"

		camara = 0
		fotogramas = 30

		# LECTURA DE SENSOR

		f = open ('php/sensor.txt','w')
		f.write("")
		f.close()

		rcv = 12;
		
		f = open ('php/sensor.txt','w')
		f.write(str(rcv))
		f.close()		

		# LECTURA DE FOTOGRAFIA

		#iniciar camara
		camera = cv2.VideoCapture(camara)
		# Captura imagen  camara
		for i in xrange(fotogramas):
			retval, im = camera.read()
			temp = im

		#print("Foto tomada")
		retval, im = camera.read()
		camera_capture = im
		file = directorio+foto_normal
		cv2.imwrite(file, camera_capture)
		del(camera)
		
		# obtiene la imagen a procesar
		image = cv2.imread(file)
		# convierte la imagen a escala de grises
		gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
		cv2.imwrite(directorio+foto_gris, gray_image)
		# difumina la imagen
		blur = cv2.blur(gray_image,(5,5),0)
		# encuentra los border que encuentre en la imagen
		edges = cv2.Canny(blur,100,150)
		# crea la imagen convertida
		cv2.imwrite(directorio+foto_procesada, edges)

		hist_full = cv2.calcHist([edges],[0],None,[256],[0,256])

		############# ESCRIBE EL VALOR EN EL ARCHIVO DE TEXTO ########################
		f = open ('php/imagen.txt','w')
		f.write(str(hist_full[0])+"-"+str(hist_full[255]))
		f.close()
		print("Imagen procesada y guardada.")

		os.system('sudo chmod -R 777 llantas')	

	time.sleep(0.3)