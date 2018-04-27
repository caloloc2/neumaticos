import cv2
directorio = 'img/'

# obtiene la imagen a procesar
image = cv2.imread(directorio+'test5.jpg')
# convierte la imagen a escala de grises
gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
# difumina la imagen
blur = cv2.blur(gray_image,(5,5),0)
# encuentra los border que encuentre en la imagen
edges = cv2.Canny(blur,100,150)
# crea la imagen convertida
cv2.imwrite(directorio+'process.jpg',edges)

hist_full = cv2.calcHist([edges],[0],None,[256],[0,256])
print hist_full













# archivo = open("archivo.txt","w")
# archivo.write(str((edges)))
# archivo.close()

# laplacian = cv2.Laplacian(edges,cv2.CV_64F)
# cv2.imwrite('gray_lap_test4.jpg',laplacian)

# cv2.imwrite('gray_test4.jpg',gray_image)
# laplacian = cv2.Laplacian(gray_image,cv2.CV_64F)
# 