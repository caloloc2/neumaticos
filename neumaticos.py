import cv2
import os, time, serial
import RPi.GPIO as GPIO

GPIO.setmode(GPIO.BCM)
GPIO.setup(18, GPIO.OUT) ## GPIO 18 como salida
GPIO.setup(23, GPIO.OUT) ## GPIO 18 como salida

directorio = 'llantas/'

GPIO.output(18, True) ## Enciendo el 2
port = serial.Serial("/dev/ttyS0", baudrate = 9600, timeout = 2)
port.close()
port.open()
time.sleep(18) # tiempo de espera 
port.close()
GPIO.output(18, False) ## Enciendo el 2


GPIO.output(18, True) ## Enciendo el 2
time.sleep(0.5)
GPIO.output(18, False) ## Enciendo el 2
time.sleep(0.5)
GPIO.output(18, True) ## Enciendo el 2
time.sleep(0.5)
GPIO.output(18, False) ## Enciendo el 2
time.sleep(0.5)
GPIO.output(18, True) ## Enciendo el 2
time.sleep(0.5)
GPIO.output(18, False) ## Enciendo el 2
time.sleep(0.5)

while(True):
	archivo = open("php/inicia_camara.txt", "r")
	inicia = archivo.read()
	archivo.close() 
	
	if (inicia=='1'):	
		GPIO.output(18, True)
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

		GPIO.output(23, True)
		time.sleep(1.5)
		port.open()
		rcv=''
		while (rcv==''):
			# recibe el dato del sensor
			rcv = port.readline()
			time.sleep(0.8)			
		port.close()
		print("Dato Recibido: ")
		print(rcv)
		GPIO.output(23, False)
		
		f = open ('php/sensor.txt','w')
		f.write(str(rcv))
		f.close()

		time.sleep(0.5)
		GPIO.output(18, False) ## Enciendo el 2
	
	time.sleep(0.3)