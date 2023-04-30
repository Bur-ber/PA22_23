const piecesContainer = document.querySelector('.captcha-piece');
const pieces = piecesContainer.querySelectorAll('img');

pieces.forEach(piece => {
  piece.addEventListener('mousedown', handleMouseDown);
  piece.addEventListener('mousemove', handleMouseMove);
  piece.addEventListener('mouseup', handleMouseUp);
});

const squares = document.querySelectorAll('.captcha-destination div');

squares.forEach(square => {
  square.addEventListener('dragover', handleDragOver);
  square.addEventListener('dragenter', handleDragEnter);
  square.addEventListener('dragleave', handleDragLeave);
  square.addEventListener('drop', handleDrop);
});

let activePiece = null;
let startX = 0;
let startY = 0;

function handleMouseDown(event) {
  activePiece = event.target;
  startX = event.clientX;
  startY = event.clientY;
  pieces.forEach(piece => piece.classList.remove('dragging'));
  activePiece.classList.add('dragging');
}

function handleMouseMove(event) {
  if (activePiece) {
    const offsetX = event.clientX - startX;
    const offsetY = event.clientY - startY;
    activePiece.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
  }
}

function handleMouseUp(event) {
  if (activePiece) {
    const pieceIndex = activePiece.getAttribute('data-index');
    const squareIndex = getSquareIndex(event.clientX, event.clientY);
    const square = document.querySelector(`.captcha-destination div:nth-child(${squareIndex + 1})`);
    const squareRect = square.getBoundingClientRect();
    const pieceRect = activePiece.getBoundingClientRect();

    if (squareIndex !== null && squareIndex === pieceIndex / 3 &&
        pieceRect.left >= squareRect.left && pieceRect.right <= squareRect.right &&
        pieceRect.top >= squareRect.top && pieceRect.bottom <= squareRect.bottom) {
      square.appendChild(activePiece);
      activePiece.classList.remove('dragging');
    } else {
      activePiece.style.transform = '';
    }
    activePiece = null;
  }
}

function getSquareIndex(x, y) {
  const squares = document.querySelectorAll('.captcha-destination div');
  for (let i = 0; i < squares.length; i++) {
    const rect = squares[i].getBoundingClientRect();
    if (x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom) {
      return i;
    }
  }
  return null;
}

function handleDragOver(event) {
  event.preventDefault();
}

function handleDragEnter(event) {
  event.target.classList.add('drag-over');
}

function handleDragLeave(event) {
  event.target.classList.remove('drag-over');
}

function handleDrop(event) {
  event.preventDefault();
  const piece = document.querySelector('.dragging');
  const square = event.target;
  square.classList.remove('drag-over');
  const img = document.createElement('img');
  img.src = piece.src;
  img.setAttribute('data-index', piece.getAttribute('data-index'));
  piece.style.display = 'none';
  square.appendChild(img);
}
