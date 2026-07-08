async function main() {
  const url = 'https://stitch.googleapis.com/mcp';
  const headers = {
    'Content-Type': 'application/json',
    'X-Goog-Api-Key': ''
  };

  const body = JSON.stringify({
    jsonrpc: '2.0',
    method: 'tools/call',
    params: {
      name: 'list_projects',
      arguments: {}
    },
    id: 1
  });

  try {
    const res = await fetch(url, {
      method: 'POST',
      headers: headers,
      body: body
    });
    const data = await res.json();
    if (data.result && data.result.content) {
      const text = data.result.content[0].text;
      const projectsObj = JSON.parse(text);
      if (projectsObj.projects) {
        projectsObj.projects.forEach(p => {
          console.log(`Project ID: ${p.name}`);
          console.log(`Title: ${p.title}`);
          console.log('---');
        });
      } else {
        console.log('No projects key found in response:', projectsObj);
      }
    } else {
      console.log('Unexpected response structure:', data);
    }
  } catch (err) {
    console.error('Error:', err);
  }
}

main();
