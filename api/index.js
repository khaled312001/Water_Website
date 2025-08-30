const { exec } = require('child_process');
const { promisify } = require('util');

const execAsync = promisify(exec);

module.exports = async (req, res) => {
  try {
    // Execute the PHP file
    const { stdout, stderr } = await execAsync('php index.php', {
      cwd: __dirname,
      env: { ...process.env, REQUEST_METHOD: req.method, QUERY_STRING: req.url }
    });

    if (stderr) {
      console.error('PHP Error:', stderr);
    }

    // Set headers
    res.setHeader('Content-Type', 'text/html');
    res.status(200).send(stdout);
  } catch (error) {
    console.error('Execution error:', error);
    res.status(500).json({ error: 'Internal server error', details: error.message });
  }
}; 