module.exports = (req, res) => {
  res.setHeader('Content-Type', 'application/json');
  res.status(200).json({
    status: 'success',
    message: 'Node.js serverless function is working!',
    timestamp: new Date().toISOString(),
    nodeVersion: process.version,
    method: req.method,
    url: req.url
  });
}; 