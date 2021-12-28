import tensorflow as tf
import numpy as np
from sklearn import datasets
import math
import sys

neurons = int(sys.argv[1])
val_checks = int(sys.argv[2])
num_epochs = int(sys.argv[3])

iris = datasets.load_iris()

x = iris.data
y = iris.target

perm = np.random.permutation(150)

x = x[perm,:]
y = y[perm]

y_shaped = np.zeros((150, 3))

for i in range(150):
    if y[i] == 0:
        y_shaped[i,0] = 1
    elif y[i] == 1:
        y_shaped[i,1] = 1
    else:
        y_shaped[i,2] = 1
        


x_train = x[:100,:]
y_train = y_shaped[:100]

x_test = x[100:125,:]
y_test = y_shaped[100:125]

x_val = x[125:150,:]
y_val = y_shaped[125:150]

train_dataset = tf.data.Dataset.from_tensor_slices((x_train, y_train))
train_dataset = train_dataset.shuffle(buffer_size=1024).batch(64)
        
val_dataset = tf.data.Dataset.from_tensor_slices((x_val, y_val))
val_dataset = val_dataset.batch(64)
        
earlystop_callback = tf.keras.callbacks.EarlyStopping(
    monitor='val_loss', min_delta=0, patience=val_checks
)

model = tf.keras.models.Sequential([
          tf.keras.layers.Dense(neurons, activation='tanh'),
          tf.keras.layers.Dense(3, activation='softmax')
        ])
        
model.compile(optimizer='adam',
                      loss='categorical_crossentropy',
                      metrics=['accuracy','AUC'])

history = model.fit(train_dataset, epochs=num_epochs, validation_data=val_dataset, validation_freq=1, callbacks=[earlystop_callback])
result = model.evaluate(x_test, y_test)

print("FINAL_RESULTS")
print(str(result[0]))
print(str(result[1]))
print(str(result[2]))