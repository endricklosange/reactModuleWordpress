const { useState, useEffect } = wp.element;
import { ImageSlider } from './ImageSlider';
import { ProductForm } from './ProductForm';

export function App() {
  const [currentDiv, setCurrentDiv] = useState(0);
  const [selections, setSelections] = useState({});
  const [data, setData] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      const endpoints = [
        '/wp-json/genres-search-api/v1/all',
        `/wp-json/parentcategories-search-api/v1/by-genre/${selections[0]}`,
        `/wp-json/categories-search-api/v1/by-parent/${selections[1]}`,
        `/wp-json/sizes-search-api/v1/by-category/${selections[2]}`,
        '/wp-json/colors-search-api/v1/all'
      ];

      const endpoint = endpoints[currentDiv] || '';
      if (!endpoint) return;

      try {
        const response = await fetch(endpoint);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const result = await response.json();
        const images = result.map(item => ({
          id: item.id,
          label: item.name,
          src: 'https://via.placeholder.com/150' // Replace with the real image URL if available
        }));
        setData(images);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    };

    fetchData();
  }, [currentDiv, selections]);

  const handleContinue = () => setCurrentDiv(prev => prev + 1);
  const handleBack = () => setCurrentDiv(prev => prev - 1);

  const updateSelections = (selected) => {
    const isMultipleSelection = currentDiv === 3 || currentDiv === 4;
    const newSelections = isMultipleSelection
      ? { ...selections, [currentDiv]: [...(selections[currentDiv] || []), selected] }
      : { ...selections, [currentDiv]: selected.id, label: selected.label };
    setSelections(newSelections);
  };

  const handleFinish = () => {
    const selectionsJson = JSON.stringify(selections);
    console.log('Final selections:', selectionsJson);
    alert(`Selections: ${selectionsJson}`);
  };

  const titles = ["Genres", "Parent Categories", "Categories", "Sizes", "Colors"];

  return (
    <div>
      {currentDiv < 5 ? (
        <ImageSlider
          title={titles[currentDiv]}
          images={data}
          handleContinue={handleContinue}
          handleBack={handleBack}
          selectedItems={selections[currentDiv] || []}
          updateSelections={updateSelections}
          currentDiv={currentDiv}
        />
      ) : (
        <ProductForm handleContinue={handleFinish} handleBack={handleBack} />
      )}
    </div>
  );
};
