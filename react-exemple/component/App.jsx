const { useState } = wp.element;
import { ImageSlider } from './ImageSlider'
import { ProductForm } from './ProductForm'
import { imageSlidersData } from '../data/imageSlidersData'


export function App() {
  const [currentDiv, setCurrentDiv] = useState(1);

  const handleContinue = () => {
    if (currentDiv < 6) {
      setCurrentDiv(currentDiv + 1);
    }
  };

  const handleBack = () => {
    if (currentDiv > 1) {
      setCurrentDiv(currentDiv - 1);
    }
  };


  return (
    <div>
      
      {currentDiv <= 5 ? (
        <ImageSlider
          title={imageSlidersData[currentDiv - 1].title}
          images={imageSlidersData[currentDiv - 1].images}
          handleContinue={handleContinue}
          handleBack={currentDiv > 1 ? handleBack : null}
        />
      ) : (
        <ProductForm handleContinue={handleContinue} handleBack={handleBack} />
      )}
    </div>
  );
}
