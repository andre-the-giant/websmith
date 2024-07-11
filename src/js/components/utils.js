import CONST from './const';
const fetchCSVData = async (url)=>{
  try {
    const response = await fetch(url);
    let csvData = await response.text();
    csvData = csvData.replace(/[^A-Z0-9,\n]+/g, '');
    csvData = csvData.replace(/\r\n/g, '\n');
    return csvData;
  } catch (error) {
    throw new Error('There was an error fetching the CSV data: ' + error.message);
  }
}
const processCSVData = (csvData)=>{
  const csvRows = csvData.split('\n');
  const csvHeaders = csvRows[0].split(',');
  const columnData = {};
  for (let j = 0; j < csvHeaders.length; j++) {
    const columnId = csvHeaders[j];
    const columnValues = [];
    for (let i = 1; i < csvRows.length; i++) {
      const csvRow = csvRows[i].split(',');
      if (csvRow.length === 1 && csvRow[0] === '') {
        continue; // Skip empty row
      }
      const cellValue = csvRow[j];
      if (cellValue === '') {
        continue; // Skip empty cell
      }
      columnValues.push(cellValue);
    }
    columnData[columnId] = columnValues;
  }
  return columnData;
}

const myFunction = ()=>{
  return true;
}

const utils = {
  myFunction:myFunction
}

export default utils;
